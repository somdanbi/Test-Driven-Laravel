@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">


                      <form action="{{ route('concerts.store') }}">
                          @csrf
                          <div class="form-group">
                              <label for="ticket_price">ticket_price:</label>
                              <input type="text" name="ticket_price" id="ticket_price" class="form-control"
                                     placeholder="ticket_price">
                          </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
