<div class="modal fade" id="recharge">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Recharge On PayTech</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newForm" action="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <select id="services" class="form-control" name="service"></select>
                        <small id="errorService" class="text-danger"></small>
                    </div>
                    <div id="info">
                        <div class="form-group">
                            <select id="product" class="form-control" name="product"></select>
                            <small id="errorService" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <select id="productId" class="form-control" name="productId"></select>
                            <small id="errorService" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="plan" name="plan"></select>
                            <small id="errorName" class="text-danger"></small>
                        </div>
                        <div id="planInfo">
                            <div class="form-group">
                                <input type="text" class="form-control" id="amount" name="amount"
                                       placeholder="Enter Amount" readonly>
                                <small id="errorName" class="text-danger"></small>
                            </div>

                            <div class="form-group">
                                <input class="form-control" id="telephone" name="telephone"
                                       placeholder="Enter Decoder Number / Telephone">
                                <small id="errorName" class="text-danger"></small>
                            </div>


                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary confirmRecharge">Recharge</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
