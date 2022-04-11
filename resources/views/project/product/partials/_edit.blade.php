<div class="modal fade" id="editProduct">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editImage" action="post" enctype="multipart/form-data">
                    <input id="productId" type="hidden">
                    <div class="form-group">
                        <select id="editServiceId" class="form-control" name="editServiceId"></select>
                        <small id="errorEditService" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="editName" name="editName"
                               placeholder="Enter Product Name">
                        <small id="errorEditName" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" id="image" name="editImage">
                        <small id="errorImage" class="text-danger"></small>
                        <img id="editImage" style="width: 100px;">
                        <input id="editImage2" type="hidden" name="existImage">
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success update">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
