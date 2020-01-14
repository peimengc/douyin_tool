@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="border-bottom">
                    <div class="float-right">
                    </div>
                    <h4>账号增粉</h4>
                    <span>所有抖音账号 <u class="c-blue">{{ $followTasks->total() }}</u></span>
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
                            <th>状态</th>
                            <th>增粉数据</th>
                            <th>对比数据</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($followTasks as $followTask)
                            <tr>
                                <td>{{ $followTask->id }}</td>
                                @include('awemeUser._userInfoTd',['awemeUser'=> $followTask->awemeUser])
                                <td>
                                    @if($followTask->status==1)
                                        <span class="badge badge-success">运行中</span>
                                    @else
                                        <span class="badge badge-secondary">已完成</span>
                                    @endif
                                </td>
                                <td>
                                    <b>目标粉丝：</b>{{ $followTask->target_fans }}
                                    <br>
                                    <b>已增加：</b>{{ $followTask->add_fans }}
                                </td>
                                <td>
                                    <b>粉丝：</b>{{ $followTask->init_fans }} -> {{ $followTask->awemeUser->fans }}
                                    <br>
                                    <b>关注：</b>{{ $followTask->init_follow }} -> {{ $followTask->awemeUser->follow }}
                                </td>
                                <td>
                                    @if($followTask->status===1)
                                        <a href="{{ $followTask->addFansUrl() }}" class="btn btn-sm btn-primary">运行</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                {{ $followTasks->links() }}
            </div>
        </div>
    </div>

    {{--扫码modal--}}

@endsection

