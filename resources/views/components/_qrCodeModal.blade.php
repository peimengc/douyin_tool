<div class="modal" id="qrCode" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">请使用抖音APP扫码</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="qr-code text-center">
                </div>
            </div>
        </div>
    </div>
</div>

@push('jsStack')
    <script>
        let token = null, checkQrCodeIntVal = null, $qrCodeBody, $qrCodeModal;

        $('#qrCode').on('show.bs.modal', function (e) {
            let $qrCodeModal = $(this)
            $qrCodeBody = $qrCodeModal.find('.modal-body .qr-code')

            $qrCodeBody.html('<h4>正在生成二维码...</h4>')

            getQrCode();
        })

        $('#qrCode').on('hide.bs.modal', function (e) {
            clearInterval(checkQrCodeIntVal)
        })
        /*继续录入*/
        $('.modal-body').on('click', '.re-qr-code', function () {
            event.preventDefault()
            getQrCode();
        })

        function getQrCode() {
            axios.get('/awemeUserCreate/getQrCode')
                .then(function (res) {
                    let response = res.data
                    if (response.error_code === 0) {
                        token = response.data.token
                        $qrCodeBody.html('<img src="data:image/png;base64, ' + response.data.qrcode + '">')
                        checkQrCodeIntVal = setInterval(checkQrCode, 2000)
                    } else {
                        $qrCodeBody.html('<h4>失败，刷新页面后重试</h4>')
                    }
                })
                .catch(function (error) {
                    clearInterval(checkQrCodeIntVal)
                    alert('系统异常，请联系管理员')
                });
        }

        function getUserInfo(redirectUrl) {
            axios.get('/awemeUserCreate/getUserInfo/', {
                params: {
                    redirect_url: redirectUrl
                }
            })
                .then(function (res) {
                    let response = res.data
                    if (response.error_code === 0) {
                        $qrCodeBody.html('<h4>账号已录入</h4>' +
                            '<a class="re-qr-code">继续录入</a>')
                    } else {
                        $qrCodeBody.html('<h4>失败，刷新页面后重试</h4>')
                    }
                })
                .catch(function (error) {
                    alert('系统异常，请联系管理员')
                });
        }

        function checkQrCode() {
            axios.get('/awemeUserCreate/checkQrCode/' + token)
                .then(function (res) {
                    let response = res.data

                    if (response.error_code !== 0) {
                        $qrCodeBody.html('<h4>失败，刷新页面后重试</h4>')
                        clearInterval(checkQrCodeIntVal);
                        return;
                    }

                    switch (parseInt(response.data.status)) {
                        case 5://token失效
                            token = response.data.token
                            $qrCodeBody.html('<img src="data:image/png;base64, ' + response.data.qrcode + '">')
                            break;
                        case 3://已同意
                            //清除任务
                            clearInterval(checkQrCodeIntVal);

                            getUserInfo(response.data.redirect_url)

                            break;
                        case 1://有效
                        case 2://已扫描

                    }
                })
                .catch(function (error) {
                    clearInterval(checkQrCodeIntVal)
                    alert('系统异常，请联系管理员')
                });
        }
    </script>
@endpush

