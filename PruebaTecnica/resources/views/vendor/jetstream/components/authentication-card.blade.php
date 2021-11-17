<div class="container">
    <div class="row justify-content-center my-3">
        <div class="col-sm-12 col-md-8 col-lg-5 my-4">
            <div>
                {{ $logo }}
            </div>

            <div class="card px-1 mx-4 violet">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

<style>
    .violet{
        background: #AE00FF;
        color:white;
        box-shadow: 0px 0px 16px -4px #000000;
    }
    a{
        color:white;
    }
    a:hover{
        color: black;
    }
    
    .form-control:focus {
        border:2px solid #FFAE00;
        box-shadow: 0px 0px;
    }
</style>