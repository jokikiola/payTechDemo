<div class="modal fade" id="addProduct">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newForm" action="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <select id="services" class="form-control" name="serviceId"></select>
                        <small id="errorService" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Product Name">
                        <small id="errorName" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" id="image" name="image">
                        <small id="errorImage" class="text-danger"></small>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary add">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
