@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <div class="float-right">
                        <button data-toggle="modal" data-target="#qrCode" class="btn btn-primary">扫码录入</button>
                    </div>
                    <h4>抖音号</h4>
                    <span>我的抖音账号 <u class="c-blue">{{ $awemeUsers->total() }}</u></span>
                </div>
            </div>
            {{--search--}}
            <div class="col-md-12 my-3">
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">提交</button>
                                <a class="btn btn-secondary" href="{{ url()->current() }}">返回</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{--table--}}
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-data">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>账号</th>
                            <th>登陆状态</th>
                            <th>粉丝</th>
                            <th>关注</th>
                            <th>互粉数据</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($awemeUsers as $awemeUser)
                            <tr>
                                <td>{{ $awemeUser->id }}</td>
                                <td>
                                    <div class="thum-box">
                                        <img src="{{ $awemeUser->avatar_uri }}"
                                             alt="头像">
                                        <div class="ml-1 d-inline-block align-middle">
                                            <div>
                                                <a target="_blank"
                                                   href="{{ $awemeUser->share_url }}">{{ $awemeUser->nick }}</a>
                                                <div class="font08 c-dgray">
                                                    <span>抖音号：{{ $awemeUser->unique_id }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($awemeUser->cookie)
                                        <span class="badge badge-success">已登录</span>
                                    @else
                                        <span class="badge badge-danger">未登录</span>
                                    @endif
                                </td>
                                <td>{{ $awemeUser->fans }}</td>
                                <td>{{ $awemeUser->follow }}</td>
                                <td>
                                    <b>粉丝：</b>{{ $awemeUser->tool_fans }}
                                    <br>
                                    <b>关注：</b>{{ $awemeUser->tool_follow }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                {{ $awemeUsers->links() }}
            </div>
        </div>
    </div>

    {{--扫码modal--}}
    <div class="modal" id="qrCode" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">抖音扫码</h5>
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

@endsection

@section('js')
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
@endsection

@section('css')
    <style>
        .modal-body img {
            width: 100%;
            height: 100%;
        }
    </style>
@endsection
