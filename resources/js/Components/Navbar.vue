<template>
  <header class="bg-gray-900 fixed z-40 w-full xl:z-50">
    <nav class="container px-4 py-4 mx-auto sm:px-6">
      <div class="flex items-center justify-between">
        <!-- Mobile menu button -->
        <div class="flex md:hidden">
          <button
            type="button"
            class="
              text-gray-500
              dark:text-gray-200
              hover:text-gray-600
              dark:hover:text-gray-400
              focus:outline-none focus:text-gray-600
              dark:focus:text-gray-400
            "
            aria-label="toggle menu"
          >
            <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
              <path
                fill-rule="evenodd"
                d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"
              ></path>
            </svg>
          </button>
        </div>

        <a
          href="/"
          class="
            inline-flex
            items-center
            text-xl
            font-bold
            text-white
            md:text-2xl
            hover:text-blue-400
          "
          ><img
            src="data:image/svg+xml;base64,Cjxzdmcgdmlld0JveD0iMCAwIDIwOSAxODAiIGZpbGw9Im5vbmUiCiAgICB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgogICAgPHBhdGggZD0iTTg3Ljg0MyAxMDguNDg3TDkwLjYxNyAxMDEuNTUzQzkxLjMxMiA5OS41NzEgOTMuNDMzIDk4LjQ3NiA5NS40NTEgOTkuMDU3TDEzMi4xNDIgMTEwLjA3MkwxNzEuNDA4IDQ1Ljk2Mkw3MS41OTggMTcuNDM0TDg3Ljg0MyAxMDguNDg3Wk0xNzMuNTQ3IDM4LjA3N1YwTDEzOC40MDIgMjYuMzQ5TDE3My41NDcgMzguMDc3Wk0yMDguNTc0IDIyLjYyNDVMMTgxLjQ3MiAwLjQzNTc5OVYyMC4yNDcyTDIwOC41NzQgMjIuNjI0NVpNMTcyLjQ3NyA1OS40MzRMMTQyLjcyMSAxMDguMTdMMTY5LjU4NSAxMDAuMDA4TDE3Mi40NzcgNTkuNDM0Wk0xMjYuNTk0IDExNi44ODdMOTYuNjQgMTA3Ljg5MkM4Ny44MDQgMTI5Ljk2MiA5My45ODUgMTE0LjkwNiA2Ni41NjYgMTc5LjcyOEwxMjYuNTk0IDExNi44ODdaTTYzLjM5NiAxNi42MDE5TDAuNjczNjM0IDI5Ljc5Nkw3NS45NTcgODYuMTc5TDYzLjM5NiAxNi42MDE5Wk01Mi43Nzc0IDc4LjgwOUwxOS42MTMzIDUzLjkyNkwwLjYzNDAzMyA2OC41ODdMNTIuNzc3NCA3OC44MDlaIiBmaWxsPSIjNjBBNUZBIi8+Cjwvc3ZnPgo="
            alt="logo"
            class="mr-2 w-7 h-7"
          />
          <span class="hidden sm:inline"
            >{{ $page.props.app.name }} <span class="text-blue-400">MMS</span></span
          ></a
        >
        
        <div class="flex items-center justify-center space-x-4 sm:space-x-6">
            <!-- <jet-nav-link
                :href="route('pm.index')"
                :active="route().current('pm.index')"
            >
                PM
            </jet-nav-link>
            <jet-nav-link
                :href="route('hse.index')"
                :active="route().current('hse.index')"
            >
                HSE
            </jet-nav-link> -->
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
export default {};
</script>