<x-app-layout>
    <x-slot name="header">
        Transactions
    </x-slot>
    <form id="generateTransaction">
        <div class="row">
            <div class="col-xl-6 col-md-12 d-flex justify-content-center">
                <img src="{{ asset('images/banker.svg') }}" alt="">
            </div>
            <div class="col-xl-6 col-md-12">
                <div class="form-group">
                    <label>My accounts</label>
                    <select id="accounts" class="custom-select form-control"></select>
                </div>
    
                <div class="form-group">
                    <label>Destination account</label>
                    <input type="text" class="form-control" id="destination" placeholder="Write destination account">
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input type="text" class="form-control" id="amount" value="0">
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-warning px-5 my-5">Submit</button>
                </div>
    
            </div>
        </div>

    </form>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
    <script src="{{ asset('js/dashboard/addTransaction.js') }}"></script>

</x-app-layout>

<style>
    
    #generateTransaction{
    transform: translateX(-800px);
    visibility: hidden;
    opacity: 0;
    transition: all 1s ease;
}    
</style>

