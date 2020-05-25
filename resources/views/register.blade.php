<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- 
    More Templates Visit ==> Free-Template.co
    -->
    <title>Registro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Free Template by Free-Template.co" />
    <meta name="keywords" content="free bootstrap 4, free bootstrap 4 template, free website templates, free html5, free template, free website template, html5, css3, mobile first, responsive" />
    <meta name="author" content="Free-Template.co" />
  
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/animate.css') }}">
    
    <link rel="stylesheet" href="{{ url('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ url('assets/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/jquery.timepicker.css') }}">
    <link href="{{ asset('alertify/css/alertify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('alertify/css/themes/bootstrap.min.css') }}" rel="stylesheet" />

    

    <link rel="stylesheet" href="{{ url('assets/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ url('assets/css/media.css')}}">
  </head>
  <body data-spy="scroll" data-target="#ftco-navbar" data-offset="200">
    
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
      <div class="container">
        <a class="navbar-brand" href="index.html">LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active"><a href="#" class="nav-link">Inicio</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Quienes Somos</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Menú</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Contacto</a></li>
          </ul>
          <button class="button">lorem</button>
        </div>
      </div>
    </nav>
    <!-- END nav -->

    <section class="ftco-cover" id="section-home">
      <img src="assets/images/6.png">
      <div class="container">
        <div class="mask">
        <div class="row information">
          <div class="col-md-12">
            <h3 class="ftco-heading ftco-animate mb-3">Registro</h3>
               <div  class="form-register"  >
      <div class="container">
    
          
             <form method="post">
              <div class="row">
                <div class="col-md-6 mb-4">
                  <input type="text" class="form-control" placeholder="Nombre" id="name">
                </div>
   
                <div class="col-md-6  mb-4">
                  <input type="email" class="form-control" placeholder="Email" id="email">
                </div>

                <div class="col-md-6 mb-4">
                   <input type="password" class="form-control" placeholder="Clave" id="password">
                </div>

                 <div class="col-md-6 mb-4">
                  <input type="password" class="form-control" placeholder="Confirmar Clave" id="password-repeat">
                </div>
                 <div class="col-md-12 sleection">
                  <p> Seleccione un Perfil </p>
                </div>          
                <div class="option-select">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="buyer" id="buyer">
                    <label class="form-check-label" for="buyer">
                    Comprador
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="seller" id="seller" >
                    <label class="form-check-label" for="seller">
                      Vendedor
                    </label>
                  </div>
                </div>


    <div class="col-md-12">
      <p> Seleccione sus rubros </p>
      </div>

      <div class="option-select">
        <div class="row">
          <div class="col-md-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="category1">
              <label class="form-check-label" for="category1">
                Comidas y platos preparados
              </label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="category2" >
              <label class="form-check-label" for="category2">
                Alimentos para preparar o envasados
              </label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="category3" >
              <label class="form-check-label" for="category3">
                Alimentos y comidas especiales
              </label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="category4" >
              <label class="form-check-label" for="category4">
                Alimentos para preparar o envasados
              </label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="category5" id="category5">
              <label class="form-check-label" for="category5">
                Logística
              </label>
            </div>
          </div>

        </div> 
      </div>
      
    </form>  
    <div style="display: flex; justify-content: center;"class="form-group row">
      <div  class="col-md-12">       
        <p class="text-center">
          <button class="res button" onclick="register()" type="button">Registrar</button>
        </p>
                </div>
              </div>
          </div>
        </div>
    </div>
          </div>
        </div>
      </div>

    </section>
    <!-- END section -->
    

    

    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/popper.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ url('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.magnific-popup.min.js') }}"></script>

    <script src="{{ url('assets/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ url('assets/js/jquery.timepicker.min.js') }}"></script>
    
    <script src="{{ url('assets/js/jquery.animateNumber.min.js') }}"></script>
    
    <script src="{{ asset('alertify/alertify.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="{{ url('assets/js/main.js') }}"></script>

    <script>
      alertify.set('notifier','position', 'top-right');
        function register(){

          let name = $("#name").val()
          let email = $("#email").val()
          let password = $("#password").val()
          let passwordRepeat = $("#password-repeat").val()
          let buyer = 0
          let seller = 0
          let category1 = 0
          let category2 = 0
          let category3 = 0
          let category4 = 0
          let category5 = 0

          if($("#buyer").is(":checked")){
              buyer = 1
          }

          if($("#seller").is(":checked")){
              seller = 1
          }


          if($("#category1").is(":checked")){
              category1 = 1
          }

          if($("#category2").is(":checked")){
              category2 = 1
          }

          if($("#category3").is(":checked")){
              category3 = 1
          }

          if($("#category4").is(":checked")){
              category4 = 1
          }

          if($("#category5").is(":checked")){
              category5 = 1
          }
            
          $.ajax({
            method: "POST",
            url: "{{ url('/register') }}",
            data: {name: name, email: email, password: password, password_confirmation: passwordRepeat, seller: seller, buyer: buyer, category1: category1, category2: category2, category3: category3, category4: category4, category5: category5, _token: "{{ csrf_token() }}"},
            success: function(result){
                swal({"icon": "success", "text": result.msg})

                $("#name").val("")
                $("#email").val("")
                $("#password").val("")
                $("#password-repeat").val("")
                $("#buyer").prop("checked", false)
                $("#seller").prop("checked", false)
                $("#category1").prop("checked", false)
                $("#category2").prop("checked", false)
                $("#category3").prop("checked", false)
                $("#category4").prop("checked", false)
                $("#category5").prop("checked", false)

            },
            error: function(error){
              $.each(error.responseJSON.errors, function(key, value){
                
                alertify.error(value[0])
              })
              //console.log("error", )
            }
          })

        }

    </script>

    
  </body>
</html>