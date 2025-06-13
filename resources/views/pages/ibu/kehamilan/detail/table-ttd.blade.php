<div class="row">
    @foreach ($ttds as $item)
        <div class="col-6 col-md-3 mb-3">
            <div class="card border {{ $item->status ? 'border-success' : 'border-secondary' }}">
                <div class="card-body py-2 text-center">
                    <div class="form-check">
                        <input class="form-check-input toggle-status" type="checkbox" data-id="{{ $item->id }}"
                            {{ $item->status ? 'checked' : '' }}>
                        <label class="form-check-label" for="check-{{ $item->id }}">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
