<!-- The Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Excel File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="uploadForm" enctype="multipart/form-data" method="POST" action="{{ route('admin.products.importProductUpdates') }}">
                    @csrf
                    <div class="form-group">
                        <label for="fileInput">Choose Excel file:</label>
                        <input type="file" class="form-control-file" id="fileInput" name="file" accept=".xlsx, .xls">
                    </div>
                    <button type="submit" class="btn btn-primary" id="uploadButton">Upload</button>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
