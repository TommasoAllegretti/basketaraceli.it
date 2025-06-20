<nav class="border-gray-200 dark:bg-gray-900 shadow-lg relative z-10">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="home" class="flex items-center space-x-3 rtl:space-x-reverse no-underline">
      <img src="{{asset('assets/logo_araceli.png')}}" class="h-10 md:h-20" title="Logo Araceli" alt="Logo Araceli" />
    </a>
    <button data-collapse-toggle="navbar-default" type="button"
      class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
      aria-controls="navbar-default" aria-expanded="false">
      <span class="sr-only">Open main menu</span>
      <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M1 1h15M1 7h15M1 13h15" />
      </svg>
    </button>
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
      <ul
        class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row lg:space-x-8 rtl:space-x-reverse md:!my-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
        <li>
          <a href="home"
            class="block py-2 px-3 rounded-sm no-underline {{ str_contains(url()->current(), 'home') ? 'text-white bg-blue-700 md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}"
            aria-current="page">Home</a>
        </li>
        <li>
          <a href="eventi"
            class="block py-2 px-3 rounded-sm no-underline {{ str_contains(url()->current(), 'eventi') ? 'text-white bg-blue-700 md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}">Eventi</a>
        </li>
        <li>
          <a href="squadre"
            class="block py-2 px-3 rounded-sm no-underline {{ str_contains(url()->current(), 'squadre') ? 'text-white bg-blue-700 md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}">Squadre</a>
        </li>
        <li>
          <a href="organizzazione"
            class="block py-2 px-3 rounded-sm no-underline {{ str_contains(url()->current(), 'organizzazione') ? 'text-white bg-blue-700 md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}">Organizzazione</a>
        </li>
        <li>
          <a href="contatti"
            class="block py-2 px-3 rounded-sm no-underline {{ str_contains(url()->current(), 'contatti') ? 'text-white bg-blue-700 md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}">Contatti</a>
        </li>
        <li>
          <a href="crm/dashboard"
            class="block py-2 px-3 rounded-sm no-underline text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">CRM</a>
        </li>
      </ul>
    </div>
  </div>
</nav>