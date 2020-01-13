<div class="modal fade" id="addFollowTask" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">账号增粉</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    @csrf
                    <div class="form-group">
                        <label for="target_fans">目标粉丝</label>
                        <input type="number" class="form-control" name="target_fans" id="target_fans" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary submit">确定</button>
            </div>
        </div>
    </div>
</div>
@push('jsStack')
    <script>
        let $modal = $('#addFollowTask'),
            $target,
            $form = $modal.find('.modal-body form'),
            $submitBtn = $modal.find('.modal-footer .submit');

        $modal.on('show.bs.modal', function (event) {
            $form.attr('action',$(event.relatedTarget).data('url'))
            $submitBtn.bind('click',function () {
                $form.submit()
            })
        })

        $modal.on('hide.bs.modal', function (event) {
            $form.attr('action','')
            $submitBtn.unbind('click')
        })

    </script>
@endpush
