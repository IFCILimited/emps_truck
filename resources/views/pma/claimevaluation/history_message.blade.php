@if ($stage->count() > 0)

    <div class="card">
        <div class="card-header">
            <h4> Claim Evaluation Progress</h4>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @if (Auth::user()->hasRole('AUDITOR') || Auth::user()->hasRole('PMA'))
                @foreach ($stage->wherein('stage_id',[1,10]) as $val)
                    <hr class="my-2">
                    <li class="list-group-item" style="border: 2px solid rgba(0, 0, 0, 0.125);border-radius:14px;">

                        <h5>
                            <strong>
                                @if ($val->stage_id == 1)
                                    PMA to Auditor
                                @elseif ($val->stage_id == 10)
                                    Auditor to PMA
                                @elseif ($val->stage_id == 20)
                                    PMA to MHI
                                @elseif ($val->stage_id == 30)
                                    MHI to PMA
                                @endif
                            </strong>
                        </h5>
                        <p>{{ $val->revert_remarks }}</p>
                            <div class="mb-3">
                                {{-- <strong>Existing Uploaded Files</strong> --}}
                                <ul class="list-group">
                                    @foreach ($uploadedFiles->where('evl_stage_id', $val->id) as $file)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a href="{{ route('doc.down', encrypt($file->upload_id)) }}"
                                                class="text-decoration-none" aria-label="Download {{ $file->doc_name }}"
                                                style="transition: color 0.3s ease;">
                                                <i class="fa fa-download me-1"></i>
                                                <span class="file-name">{{ $file->doc_name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        <p><b>Submitted On:
                                {{ $val->created_at }}
                            </b></p>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($val->created_at)->diffForHumans() }}</small>
                    </li>
                @endforeach
                @endif
                @if (Auth::user()->hasRole('MHI') || Auth::user()->hasRole('PMA'))
                @foreach ($stage->wherein('stage_id',[20,30]) as $val)
                    <hr class="my-2">
                    <li class="list-group-item" style="border: 2px solid rgba(0, 0, 0, 0.125);border-radius:14px;">

                        <h5>
                            <strong>
                                @if ($val->stage_id == 1)
                                    PMA to Auditor
                                @elseif ($val->stage_id == 10)
                                    Auditor to PMA
                                @elseif ($val->stage_id == 20)
                                    PMA to MHI
                                @elseif ($val->stage_id == 30)
                                    MHI to PMA
                                @endif
                            </strong>
                        </h5>
                        <p>{{ $val->revert_remarks }}</p>
                            <div class="mb-3">
                                {{-- <strong>Existing Uploaded Files</strong> --}}
                                <ul class="list-group">
                                    @foreach ($uploadedFiles->where('evl_stage_id', $val->id) as $file)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a href="{{ route('doc.down', encrypt($file->upload_id)) }}"
                                                class="text-decoration-none" aria-label="Download {{ $file->doc_name }}"
                                                style="transition: color 0.3s ease;">
                                                <i class="fa fa-download me-1"></i>
                                                <span class="file-name">{{ $file->doc_name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        <p><b>Submitted On:
                                {{ $val->created_at }}
                            </b></p>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($val->created_at)->diffForHumans() }}</small>
                    </li>
                @endforeach
                @endif
            </ul>
        </div>
    </div>

@endif
