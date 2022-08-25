@extends('layouts.main')
@section('content')

 <!-- Page content -->
   <div class="container-fluid mt-4">
     
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Project Detail</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-bordered" id="dataTables">
      
                <tbody class="list">
               
                  <tr>
                    <th>Client Name</th>
                    <td class="budget">{{$project->client_name}}</td>
                  </tr>
                   <tr>
                    <th>Project Name</th>
                    <td class="budget">{{$project->project_name}}</td>
                  </tr>
                   <tr>
                    <th>Contact Type</th>
                    <td class="budget">{{($project->contract_type->type)}}</td>
                  </tr>
                   <tr>
                    <th>Project Type</th>
                    <td class="budget">{{($project->project_type->type)}}</td>
                  </tr>
                  <tr>
                    <th>Start Date</th>
                    <td class="budget">{{$project->start_date}}</td>
                  </tr>
                   <tr>
                    <th>End Date</th>
                    <td class="budget">{{($project->end_date)}}</td>
                  </tr>
                  <tr>
                    <th>Job Posting Url</th>
                    <td class="budget">{{$project->job_posting_url}}</td>
                  </tr>
                  <tr>
                    <th>Total Price</th>
                    <td class="budget">{{($project->total_price)}}</td>
                  </tr>

                   <tr>
                    <th>Payment Received</th>
                    <td class="budget">{{($project->payment_received)}}</td>
                  </tr>

                </tbody>
              </table>
               
            </div>
          </div>
        </div>
      </div>
        <!-- Footer -->
     @include('layouts.footer')
    </div>
@endsection