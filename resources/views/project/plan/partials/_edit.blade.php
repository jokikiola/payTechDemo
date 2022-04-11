<div class="modal fade" id="editPlan">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Plan & Subscription</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="post" enctype="multipart/form-data">
                    <input type="hidden" id="planId">
                    <div class="form-group">
                        <input id="editService" class="form-control" name="service" readonly>
                    </div>
                    <div class="form-group">
                        <input id="editProduct" class="form-control" name="product" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="editName" name="editName"
                               placeholder="Enter Plan Name">
                        <small id="errorName" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="editAmount" name="editAmount"
                               placeholder="Enter Amount">
                        <small id="errorName" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="editDescription" name="editDescription"
                               placeholder="Enter Description">
                        <small id="errorName" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" id="editImage" name="editImage">
                        <small id="errorImage" class="text-danger"></small>
                        <img id="showImage" style="width: 100px;">
                        <input id="editImage2" type="hidden" name="editImage2">
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
