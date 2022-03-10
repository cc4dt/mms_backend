<?php

namespace App\Datatable;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class DatatableBuilder
{
    private Request $request;


    /** @var Spatie\QueryBuilder\QueryBuilder */
    public $queryBuilder;

    /** @var Function */
    protected $transformCallback;
    
    /** @var array */
    protected $options;

    /** @var \Illuminate\Support\Collection */
    protected $columns;
    
    /** @var \Illuminate\Support\Collection */
    protected $filters;
    
    /** @var \Illuminate\Support\Collection */
    protected $buttons;

    public function __construct($subject, ?Request $request = null)
    {
        $this->queryBuilder = QueryBuilder::for($subject);
        $this->request = $request ?? app(Request::class);
        
        $this->options = array();
        $this->columns = new Collection;
        $this->filters = new Collection;
        $this->buttons = new Collection;
    }

    /**
     * @param EloquentBuilder|Relation|string $subject
     * @param Request|null $request
     *
     * @return static
     */
    public static function of($subject, ?Request $request = null): self
    {
        return new static($subject, $request);
    }
    
    /**
     * Collects all properties and sets the default
     * values from the request query.
     *
     * @return array
     */
    public function getProps(): array
    {
        return [
            'sort'  => (object)  $this->sortBy(),
            'options' => (object) $this->options,
            'columns' => $this->columns->isNotEmpty() ? $this->columns->all() : (object) [],
            'filters' => $this->filters->isNotEmpty() ? $this->filters->all() : (object) [],
        ];
    }
    
    /**
     * Give the query builder props to the given Inertia response.
     *
     * @param \Inertia\Response $response
     * @return \Inertia\Response
     */
    public function applyTo(Response $response): Response
    {
        return $response
            ->with('datatableMeta', $this->getProps())
            ->with('paginationData', $this->getData());
    }

    public function transform($callback): self
    {
        $this->transformCallback = $callback;
        return $this;
    }

    public function SortBy()
    {
        // $sort = $this->request->query('sort');
        // if($sort) {
        //     if($sort[0] == '-')
        //         return [
        //             'key' => $sort,
        //             'dir' => 'desc',
        //         ];
        //     else
        //         return [
        //             'key' => $sort,
        //             'dir' => 'asc',
        //         ];
        // } else
        if(isset($this->options['default_sort'])) {
            return $this->options['default_sort'];
        }
    }
    
    public function getData(): object
    {
        $size = $this->request->query('size');
        
        if(isset($this->options['default_sort']))
            $this->queryBuilder->defaultSort($this->options['default_sort']['key']);

       $this->queryBuilder
            ->allowedSorts($this->allowedSorts())
            ->allowedFilters($this->allowedFilters());

        $data = $this->queryBuilder
            ->paginate($size)
            // ->appends(request()->query())
            ->withQueryString();
        
            
        if($this->transformCallback)
            $data->getCollection()->transform($this->transformCallback);
        
        return $data;
    }

    /**
     * Transform the columns collection so it can be used in the Inertia front-end.
     *
     * @return array
     */
    private function allowedFilters(): array
    {
        $columns = $this->columns;
        $filters = $this->filters;
        $allowedFilters = [];
        if(!isset($this->options['global_search']) || $this->options['global_search'])
            $allowedFilters[] = AllowedFilter::callback('global', function ($query, $value) use($columns) {
                $query->where(function ($q) use ($value, $columns) {
                    $f = true;
                    foreach($columns as $key => $column) {
                        if(!isset($column['searchable']) || $column['searchable'])
                        {
                            if($f) {
                                $f = false;
                                $q = $q->where($key, 'LIKE', "%{$value}%");
                            } else {
                                $q = $q->orWhere($key, 'LIKE', "%{$value}%");
                            }
                        }
                    }
                });
            });

        foreach ($columns as $key => $value) {
            if(!isset($value['searchable']) || $value['searchable'])
                $allowedFilters[] = $key;
        }

        foreach ($filters as $key => $value) {
            if(isset($value['type'])) {
                if(in_array($value['type'], ['date_between', 'number_between'])) {
                    $allowedFilters[] = AllowedFilter::scope($key);
                } elseif(in_array($value['type'], ['select', 'multiple_select', 'check'])) {
                    $allowedFilters[] = AllowedFilter::exact($key);
                } else {
                    $allowedFilters[] = $key;
                }
            }
        }
        return $allowedFilters;
    }

    /**
     * Transform the search collection so it can be used in the Inertia front-end.
     *
     * @return array
     */
    private function allowedSorts(): array
    {
        return $this->columns
            ->filter(function ($item) {
                return !isset($value['sortable']) || $value['sortable'];
            })->keys()->toArray();
    }

    /**
     * Transform the filters collection so it can be used in the Inertia front-end.
     *
     * @return \Illuminate\Support\Collection
     */
    private function transformFilters(): Collection
    {
        $filters = $this->request->query('filter', []);

        if (empty($filters)) {
            return $this->filters;
        }

        return $this->filters->map(function ($filter, $key) use ($filters) {
            if (!array_key_exists($key, $filters)) {
                return $filter;
            }

            $value = $filters[$key];

            if (!array_key_exists($value, $filter['options'] ?? [])) {
                return $filter;
            }

            $filter['value'] = $value;

            return $filter;
        });
    }
    
    /**
     * Add a column to the query builder.
     *
     * @param string $name
     * @param array $options
     * @return self
     */
    public function addColumn(string $name, array $options): self
    {
        $this->columns->put($name, $options);

        return $this;
    }

    public function addColumns(array $columns = []): self
    {
        foreach ($columns as $key => $value) {
            $this->addColumn($key, $value);
        }

        return $this;
    }

    /**
     * Add a filter to the query builder.
     *
     * @param string $name
     * @param array $options
     * @return self
     */
    public function addFilter(string $name, array $options): self
    {
        $this->filters->put($name, $options);

        return $this;
    }

    public function addFilters($filters): self
    {
        foreach ($filters as $key => $value) {
            $this->addFilter($key, $value);
        }

        return $this;
    }
    
    public function defaultSort(String $key, String $dir='asc'): self
    {
        $this->options['default_sort'] = [
            'key' => $key,
            'dir' => $dir
        ];
        return $this;
    }
    
    public function actionButtons(bool $status): self
    {
        $this->options['action_buttons'] = $status;
        return $this;
    }
    
    public function createRoute(String $var): self
    {
        $this->options['create_route'] = $var;
        return $this;
    }
    
    public function deleteRoute(String $var): self
    {
        $this->options['delete_route'] = $var;
        return $this;
    }
    
    public function editRoute(String $var): self
    {
        $this->options['edit_route'] = $var;
        return $this;
    }
    
    public function showRoute(String $var): self
    {
        $this->options['show_route'] = $var;
        return $this;
    }

    /**
     * Disable the global search.
     *
     * @return self
     */
    public function disableGlobalSearch(): self
    {
        $this->options['global_search'] = false;

        return $this;
    }
}
