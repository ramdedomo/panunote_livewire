<div>
    <main class="">
        <div class="">
            <div class="bg-white p-0 m-0">
                <div class="sizebox"></div>

                <div class="px-3 my-3">
                    <div
                        class="justify-content-center align-items-center d-flex rounded-3 bg-semi-dark p-3 border border-1 border-primary">
                        <span class="text-primary px-2 fs-4 fw-bold d-flex justify-content-between w-100">
                            <div>
                                <i class="bi bi-list-ul"></i>
                            </div>
                            <div>
                                Activity Logs
                            </div>
    
                        </span>
                    </div>
                </div>

                <div class="px-3">
                    <div class="bg-semi-dark rounded-3 p-2 d-flex justify-content-between">
                         <div>
                            <input type="text" class="form-control" wire:model="search" placeholder="Search">
                         </div>

                         <div>
                            <input type="date" class="form-control" wire:model='date' placeholder="Search">
                         </div>
                    </div>
                </div>


                <div class="p-3">
                    <div class="bg-semi-dark p-2 rounded">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                  <tr>
                                    <th scope="col">Description</th>
                                    <th scope="col">Date</th>
                                  </tr>
                                </thead>

                                <tbody>
                                    @foreach ($logs as $log)
                                    <tr>
                                        <td>{{$log->description}}</td>
                                        <td>{{ date_format(Carbon\Carbon::parse($log->created_at), 'm/d h:i A') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>





                    <div class="mt-3">
                        {{ $logs->links() }}
                    </div>
                 
                </div>

                <div class="px-3 mb-3">
                    <div class="bg-semi-dark p-4 rounded-3  border-bottom border-5 rounded-3 border-primary">
    
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
