@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <div class="float-right">
                    </div>
                    <h4>账号增粉</h4>
                    <span>所有抖音账号 <u class="c-blue">{{ $awemeUsers->total() }}</u></span>
                </div>
            </div>
            {{--search--}}
            <div class="col-md-12 my-3">
                <form method="get" action="">
                    <div class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="关键字搜索" name="keywords" value="{{ request('keywords') }}">
                        </div>
                        <div class="col">
                            <select class="form-control" name="user_id">
                                <option value="">请选择用户</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            @if((int)request('user_id') === $user->id) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="submit" class="btn btn-primary">提交</button>
                                <a href="{{ url()->current() }}" class="btn btn-secondary">返回</a>
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
                            <th>操作</th>
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
                                                <div class="font08 c-dgray">
                                                    <span>更新于：{{ $awemeUser->updated_at->diffForHumans() }}</span>
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
                                <td>
                                    <div class="btn btn-group-sm">
                                        <button
                                            class="btn btn-primary"
                                            data-url="{{ $awemeUser->addFollowTaskUrl() }}"
                                            data-toggle="modal"
                                            data-target="#addFollowTask"
                                        >增粉</button>
                                    </div>
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

    @include('awemeUserFollow._addFollowTaskModal')

@endsection

