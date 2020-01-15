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
                    <span>更新于：{{ $awemeUser->update_time->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </div>
</td>
