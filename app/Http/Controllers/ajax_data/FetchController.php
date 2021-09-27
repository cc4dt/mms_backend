<?php

namespace App\Http\Controllers\ajax_data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blocks;
use DB;

class FetchController extends Controller {
    public function __construct() {
        $this->middleware( 'auth' );
    }

    public function getdata2( $table, $id, $cid ) {

        if ( $table == 'service' ) {

            $Rows = DB::table( $table )->where( 'service_category', $id )->where( 'clientid', $cid )->pluck( 'service', 'id' );
            return $Rows;

        }

    }

    public function getdata( $table, $id ) {

      
        if ( $table == 'stations' ) {

            $Rows = DB::table( $table )->where( 'state_id', $id )->pluck( 'name_en', 'id' );
            return $Rows;

        }

        if ( $table == 'contracts' ) {

            $date = date( 'Y-m-d' );
            $Rows = DB::table( $table )->where( 'clientid', $id )->
            where( 'startdate', '<=', $date )->
            where( 'enddate', '>=', $date )->
            pluck( 'contractno', 'id' );
            return $Rows;
        }

        if ( $table == 'breakdowns' ) {

            $Rows = DB::table( $table )->where( 'equipment_id', $id )->pluck( 'name_en', 'id' );
            return $Rows;

        }

        if ( $table == 'wells' ) {

            $Rows = DB::table( $table )->where( 'locationid', $id )->pluck( 'wellName', 'id' );
            return $Rows;

        }

        if ( $table == 'clients' ) {

            $Rows = DB::table( $table )->where( 'id', '!=', $id )->pluck( 'name', 'id' );
            return $Rows;

        }

        if ( $table == 'service2' ) {

            $Rows = DB::table( 'service' )->where( 'id', $id )->pluck( 'uom', 'id' );
            return $Rows;

        }

        if ( $table == 'service3' ) {

            $Rows = DB::table( 'service' )->where( 'id', $id )->pluck( 'price', 'id' );
            return $Rows;

        }

    }

}
