<div class="card">
        <div class="card-header">
            Preorder Details
        </div>
        <div class="card-body">

            <!-- Search Form with From Date and To Date -->
            <form method="GET" action="{{ route('admin.presaleorders.searchbydatepost') }}">
                <div class="row m-5">
                    <div class="col-md-3">
                        <label for="from_date">From Date</label>
                        <input type="text" name="from_date" class="form-control datetime" id="from_date">
                    </div>
                    <div class="col-md-3">
                        <label for="to_date">To Date</label>
                        <input type="text" name="to_date" class="form-control datetime" id="to_date">
                    </div>
                    <div class="col-md-2 mt-4">
                        <!-- Search Button with Loader -->
                        <button type="button" id="search-btn" onclick="getDetails()" class="btn btn-primary mt-2">
                            <span id="search-text">Search</span>
                            <span id="search-loader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                        </button>
                    </div>
                    <div class="col-md-4 text-right mt-4">
                        <!-- Export Buttons -->
                        <a href="#" class="btn btn-info export-btn" data-type="csv">Export CSV</a>
                        <a href="#" class="btn btn-success export-btn" data-type="excel">Export Excel</a>
                        {{-- <a href="#" class="btn btn-danger export-btn" data-type="pdf">Export PDF</a> --}}
                    </div>
                </div>
            </form>

            <!-- DataTable -->
            <div id="datatable-container"></div>
        </div>
    </div>
