spawnModal = function($title,$content,$cancelBtn = "cancel",$okBtn = "ok",onCancel,onOk){
    $('.wrapper').append('<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true"></div>');
    $modal = $("#Modal")
    $modal.html(`
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"></button>
                <button type="button" class="btn btn-primary" id="modalButtonOk"></button>
            </div>
        </div>
    </div>
    `);
    $("#ModalLabel").html($title);
    $("#Modal .modal-body p").html($content)
    $("#Modal button.btn.btn-secondary").html($cancelBtn)
    $("#Modal button.btn.btn-primary").html($okBtn)
    $modal.modal('show');
    $('#modalButtonOk').on("click", function(){
        $modal.modal('hide');
        onOk();
        $modal.on('hidden.bs.modal', function () {
            $modal.remove();
        })
    })
    $modal.on('hidden.bs.modal', function () {
        onCancel();
        $modal.remove();
    })
}