<div class="card mt-3">
    <div class="card-body">
        <div class="d-flex flex-row">

            <!-- ユーザページにリンク（人型アイコン） -->
            <a href="{{ route('users.show', ['name' => $person->name]) }}" class="text-dark">
                <i class="fas fa-user-circle fa-3x"></i>
            </a>

            <!-- 本人じゃなかったらフォローボタン表示 -->
            @if( Auth::id() !== $person->id )
            <follow-button class="ml-auto" :initial-is-followed-by='@json($person->isFollowedBy(Auth::user()))' :authorized='@json(Auth::check())' endpoint="{{ route('users.follow', ['name' => $person->name]) }}">
            </follow-button>
            @endif

        </div>
        <!-- ユーザページにリンク（名前） -->
        <h2 class="h5 card-title m-0">
            <a href="{{ route('users.show', ['name' => $person->name]) }}" class="text-dark">{{ $person->name }}</a>
        </h2>
    </div>
</div>