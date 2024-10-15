<!-- /*
* Bootstrap 5
* Template Name: Furni
* Developer : Ahmad Rizki
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
@include('shared.header')

<body>

    <!-- Start Header/Navigation -->
    @include('shared.navbar')
    <!-- End Header/Navigation -->

    @yield('content')

    <!-- Start Footer Section -->
    @include('shared.footer')
    <!-- End Footer Section -->


    @include('shared.script')
</body>

</html>
