{{-- -------------------- Saved Messages -------------------- --}}

@if($get == 'group')
    <table class="messenger-list-item" data-contact="{{ Auth::user()->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td>
            <div class="saved-messages avatar av-m">
                <span class="fas fa-comments"></span>
            </div>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ Auth::user()->id }}" data-type="user">Your Group <span>You</span></p>
                <span>Save messages secretly</span>
            </td>
        </tr>
    </table>
@endif




