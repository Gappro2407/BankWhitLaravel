<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">

<x-app-layout>
<x-slot name="header">
    Transference List
</x-slot>
        <div class="shadow-sm">
            <div class="container">
                <table id="transactions" class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                Monto
                            </th>
                            <th scope="col">
                               Cuenta Origen
                            </th>
                            <th scope="col">
                            Cuenta Destino
                            </th>
                            <th scope="col">
                                Fecha
                            </th>
                            <th scope="col">
                                Estado
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tablita">
                        
                    </tbody>
                </table>
            </div>
        </div>

        <style>
    
            #transactions{
            transform: translateY(-800px);
            visibility: hidden;
            opacity: 0;
            transition: all 1s ease;
        }    
        </style>
        
</x-app-layout>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js/dashboard/transactions.js') }}"></script>




