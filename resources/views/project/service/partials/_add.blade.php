<div class="modal fade" id="addService">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Service</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newForm" action="post" enctype="multipart/form-data" >
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Service">
                        <small id="errorName" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" id="image" name="image">
                        <small id="errorName" class="text-danger"></small>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary addService">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
