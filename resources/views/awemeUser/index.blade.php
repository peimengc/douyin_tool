@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <div class="float-right">
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
                            <th>互粉数据</th>
                            <th>当前数据</th>
                            <th>初始数据</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($awemeUsers as $awemeUser)
                            <tr>
                                <td>{{ $awemeUser->id }}</td>
                                @include('awemeUser._userInfoTd')
                                <td>
                                    @if($awemeUser->cookie)
                                        <span class="badge badge-success">已登录</span>
                                    @else
                                        <span class="badge badge-danger">未登录</span>
                                    @endif
                                </td>
                                <td>
                                    <b>粉丝：</b>{{ $awemeUser->tool_fans }}
                                    <br>
                                    <b>关注：</b>{{ $awemeUser->tool_follow }}
                                </td>
                                <td>
                                    <b>粉丝：</b>{{ $awemeUser->fans }}
                                    <br>
                                    <b>关注：</b>{{ $awemeUser->follow }}
                                </td>
                                <td>
                                    <b>粉丝：</b>{{ $awemeUser->init_fans }}
                                    <br>
                                    <b>关注：</b>{{ $awemeUser->init_follow }}
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

@endsection

