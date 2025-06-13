 @extends('layouts.app')
 @section('title', 'Dashboard')
 @push('styles')
     <!-- CSS Libraries -->
     <link rel="stylesheet" href="{{ asset('') }}assets/modules/jqvmap/dist/jqvmap.min.css">
     <link rel="stylesheet" href="{{ asset('') }}assets/modules/summernote/summernote-bs4.css">
     <link rel="stylesheet" href="{{ asset('') }}assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
     <link rel="stylesheet" href="{{ asset('') }}assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
     <style>
         .section>*:first-child {
             margin-top: 55px;
         }
     </style>
 @endpush
 @section('content')
     <section class="section">
         <div class="row">
             <div class="col-lg-6 col-md-4 col-sm-12">
                 <div class="card card-statistic-2">
                     <div class="card-icon shadow-primary bg-primary">
                         <i class="fas fa-users"></i>
                     </div>
                     <div class="card-wrap">
                         <div class="card-header">
                             <h4>Ibu</h4>
                         </div>
                         <div class="card-body">
                             {{ $ibus }}
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 col-md-4 col-sm-12">
                 <div class="card card-statistic-2">
                     <div class="card-icon shadow-primary bg-primary">
                         <i class="fas fa-child"></i>
                     </div>
                     <div class="card-wrap">
                         <div class="card-header">
                             <h4>Kehamilan</h4>
                         </div>
                         <div class="card-body">
                             {{ $kehamilans }}
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 col-md-4 col-sm-12">
                 <div class="card card-statistic-2">
                     <div class="card-icon shadow-primary bg-primary">
                         <i class="fas fa-hospital"></i>
                     </div>
                     <div class="card-wrap">
                         <div class="card-header">
                             <h4>Pelayanan</h4>
                         </div>
                         <div class="card-body">
                             {{ $pelayanans }}
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 col-md-4 col-sm-12">
                 <div class="card card-statistic-2">
                     <div class="card-icon shadow-primary bg-primary">
                         <i class="fas fa-user"></i>
                     </div>
                     <div class="card-wrap">
                         <div class="card-header">
                             <h4>Nifas</h4>
                         </div>
                         <div class="card-body">
                             {{ $nifas }}
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 col-md-4 col-sm-12">
                 <div class="card card-statistic-2">
                     <div class="card-icon shadow-primary bg-primary">
                         <i class="fas fa-clipboard"></i>
                     </div>
                     <div class="card-wrap">
                         <div class="card-header">
                             <h4>Rujukan</h4>
                         </div>
                         <div class="card-body">
                             {{ $rujukan }}
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 col-md-4 col-sm-12">
                 <div class="card card-statistic-2">
                     <div class="card-icon shadow-primary bg-primary">
                         <i class="fas fa-users"></i>
                     </div>
                     <div class="card-wrap">
                         <div class="card-header">
                             <h4>Admin</h4>
                         </div>
                         <div class="card-body">
                             {{ $users }}
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
 @endsection
 @push('scripts')
     <!-- JS Libraies -->
     <script src="{{ asset('') }}assets/modules/jquery.sparkline.min.js"></script>
     <script src="{{ asset('') }}assets/modules/chart.min.js"></script>
     <script src="{{ asset('') }}assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
     <script src="{{ asset('') }}assets/modules/summernote/summernote-bs4.js"></script>
     <script src="{{ asset('') }}assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

     <!-- Page Specific JS File -->
     <script src="{{ asset('') }}assets/js/page/index.js"></script>
 @endpush
