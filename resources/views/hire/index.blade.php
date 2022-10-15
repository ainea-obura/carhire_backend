@extends('layouts.master')

@section('content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">hire Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($hire)>0)
        <table class="table table-bhireed" id="hire-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>user_id</th>
              <th>car_id</th>
              <th>start</th>
              <th>end</th>
              <th>amount</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
            <th>S.N.</th>
              <th>user_id</th>
              <th>car_id</th>
              <th>start</th>
              <th>end</th>
              <th>amount</th>
              </tr>
          </tfoot>
          <tbody>
            @foreach($hire as $hire)  
                <tr>
                    <td>{{$hire->user_id}}</td>
                    <td>{{$hire->car_id}}</td>
                    <td>{{$hire->start}}</td>
                    <td>{{$hire->end}}</td>
                    <td>{{$hire->amount}}</td>
                    <td>
                        <a href="{{route('hire.show',$hire->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;bhire-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                        <a href="{{route('hire.edit',$hire->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;bhire-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('hire.destroy',[$hire->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$hire->id}} style="height:30px; width:30px;bhire-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$hires->links()}}</span>
        @else
          <h6 class="text-center">No hires found!!! Please hire some cars</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('admin/js/demo/datatables-demo.js')}}"></script>
  <script>
      
      $('#hire-dataTable').DataTable( {
            "columnDefs":[
                {
                    "hireable":false,
                    "targets":[8]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush