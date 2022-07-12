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
      <h6 class="m-0 font-weight-bold text-primary float-left">Cars List</h6>
      <a href="{{route('car.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Car</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <div class="col-md-6">
          <h3>Products</h3>
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Car Title</th>
                      <th>Price</th>
                      <th>Total Images</th>
                      <th>View Image</th>
                  </tr>
              </thead>
              <tbody>
                  @php $i=1; @endphp
                  @forelse ($products as $product)
                      <tr>
                          <td>{{$i++;}}</td>
                          <td>{{$product->title}}</td>
                          <td>KSh{{$product->price}}</td>
                          <td>{{$product->images->count()}}</td>
                          <td>
                              <a href={{route('car.images',$product->id)}} class="btn btn-outline-dark">View</a>
                          </td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="5" class="text-center">No products yet!</td>
                      </tr>
                  @endforelse
              </tbody>
          </table>
      </div>
        
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
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
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
      
      $('#product-dataTable').DataTable( {
        "scrollX": false
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[10,11,12]
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