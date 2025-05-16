  <div class="row" style="position: fixed;top:81px;  width: 79%; z-index: 1000;">
      <div class="col-md-12">
          <div class="card border-start border-4 border-info shadow-sm">
              <div class="card-body">
                  <div class="row ">
                      <div class="col-md-4">
                          <strong>Claim Number:</strong>
                          <div>{{ $buyerDetails[0]->claim_no ?? '-' }}</div>
                      </div>
                      <div class="col-md-4">
                          <strong>OEM Name:</strong>
                          <div>
                              {{ !empty($buyerDetails[0]->oemname) ? strtoupper($buyerDetails[0]->oemname) : '-' }}
                          </div>
                      </div>
                      <div class="col-md-4">
                          <strong>Segment Name:</strong>
                          <div>{{ $buyerDetails[0]->vehicle_segment ?? '-' }}</div>
                      </div>
                  </div>
              </div>

          </div>
      </div>
  </div>
  <div style="height: 90px;"></div>
  <div class="row mt-3">
      <div class="col-md-12">
          <div class="card border-start border-4 border-info shadow-sm">
              <div class="card-body">
                  <h5 class="card-title text-info">Claim Evaluation Summary</h5>
                  <div class="row text-center mt-5">
                      <div class="{{ Auth::user()->hasRole('PMA') ? 'col-md-4' : 'col-md-6' }} mb-3">
                          <div class="border p-3 rounded bg-dark">
                              <h4 class="text-white fw-bold mb-3">PMA Summary</h4>
                              <div class="d-flex justify-content-between mb-2">
                                  <span class="fw-bold">✅ Approved</span>
                                  <span class="fw-bold">
                                      {{ $buyerDetails->where('pma_status_id', '1')->count() > 0
                                          ? $buyerDetails->where('pma_status_id', '1')->count() . ' | ₹ ' . number_format($buyerDetails->sum('pma_amount'), 2)
                                          : '' . ' | ₹ ' . number_format($buyerDetails->sum('pma_amount'), 2) }}
                                  </span>
                              </div>
                              <div class="d-flex justify-content-between mb-2">
                                  <span class="fw-bold">❌ Rejected</span>
                                  <span class="fw-bold">
                                      {{ $buyerDetails->where('pma_status_id', '=', '2')->count() > 0
                                          ? $buyerDetails->where('pma_status_id', '=', '2')->count() .
                                              ' | ₹ ' .
                                              number_format($buyerDetails->sum('pma_rej_amount'), 2)
                                          : '' . ' | ₹ ' . number_format($buyerDetails->sum('pma_rej_amount'), 2) }}
                                  </span>
                              </div>
                              <div class="d-flex justify-content-between">
                                  <span class="fw-bold">⏸️ Withheld</span>
                                  <span class="fw-bold">
                                      {{ $buyerDetails->where('pma_status_id', '=', '3')->count() > 0
                                          ? $buyerDetails->where('pma_status_id', '=', '3')->count() .
                                              ' | ₹ ' .
                                              number_format($buyerDetails->sum('pma_wthhld_amount'), 2)
                                          : '' . ' | ₹ ' . number_format($buyerDetails->sum('pma_wthhld_amount'), 2) }}
                                  </span>
                              </div>
                              <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                  <span class="fw-bold text-white">🔢 Total</span>
                                  <span class="fw-bold text-white">
                                      {{ $buyerDetails->count() }}
                                      |
                                      ₹
                                      {{ number_format(
                                          $buyerDetails->sum('pma_amount') + $buyerDetails->sum('pma_rej_amount') + $buyerDetails->sum('pma_wthhld_amount'),
                                          2,
                                      ) }}
                                  </span>
                              </div>
                          </div>
                      </div>
                      @if (!Auth::user()->hasRole('MHI'))
                          {{-- Auditor Status --}}
                          <div class="{{ Auth::user()->hasRole('PMA') ? 'col-md-4' : 'col-md-6' }} mb-3">
                              <div class="border p-3 rounded bg-dark">
                                  <h4 class="text-white fw-bold mb-3">Auditor Summary</h4>
                                  <div class="d-flex justify-content-between mb-2">
                                      <span class="fw-bold">✅ Approved</span>
                                      <span class="fw-bold">
                                          {{ $buyerDetails->where('auditor_status_id', '1')->count() > 0
                                              ? $buyerDetails->where('auditor_status_id', '1')->count() .
                                                  ' | ₹ ' .
                                                  number_format($buyerDetails->sum('auditor_amount'), 2)
                                              : '-' }}
                                      </span>
                                  </div>
                                  <div class="d-flex justify-content-between mb-2">
                                      <span class="fw-bold">❌ Rejected</span>
                                      <span class="fw-bold">
                                          {{ $buyerDetails->where('auditor_status_id', '2')->count() > 0
                                              ? $buyerDetails->where('auditor_status_id', '2')->count() .
                                                  ' | ₹ ' .
                                                  number_format($buyerDetails->sum('auditor_rej_amount'), 2)
                                              : '' . ' | ₹ ' . number_format($buyerDetails->sum('auditor_rej_amount'), 2) }}
                                      </span>
                                  </div>
                                  <div class="d-flex justify-content-between">
                                      <span class="fw-bold">⏸️ Withheld</span>
                                      <span class="fw-bold">
                                          {{ $buyerDetails->where('auditor_status_id', '3')->count() > 0
                                              ? $buyerDetails->where('auditor_status_id', '3')->count() .
                                                  ' | ₹ ' .
                                                  number_format($buyerDetails->sum('auditor_wthhld_amount'), 2)
                                              : '' . ' | ₹ ' . number_format($buyerDetails->sum('auditor_wthhld_amount'), 2) }}
                                      </span>
                                  </div>

                                  <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                      <span class="fw-bold text-white">🔢 Total</span>
                                      <span class="fw-bold text-white">
                                          {{ $buyerDetails->count() }}
                                          |
                                          ₹
                                          {{ number_format(
                                              $buyerDetails->sum('auditor_amount') +
                                                  $buyerDetails->sum('auditor_rej_amount') +
                                                  $buyerDetails->sum('auditor_wthhld_amount'),
                                              2,
                                          ) }}
                                      </span>
                                  </div>
                              </div>
                          </div>
                      @endif

                      @if (Auth::user()->hasRole('MHI') || Auth::user()->hasRole('PMA'))
                          {{-- Auditor Status --}}
                          <div class="{{ Auth::user()->hasRole('PMA') ? 'col-md-4' : 'col-md-6' }} mb-3">
                              <div class="border p-3 rounded bg-dark">
                                  <h4 class="text-white fw-bold mb-3">MHI Summary</h4>
                                  <div class="d-flex justify-content-between mb-2">
                                      <span class="fw-bold">✅ Approved</span>
                                      <span class="fw-bold">
                                          {{ $buyerDetails->where('mhi_status_id', '1')->count() > 0
                                              ? $buyerDetails->where('mhi_status_id', '1')->count() . ' | ₹ ' . number_format($buyerDetails->sum('mhi_amount'), 2)
                                              : '-' }}
                                      </span>
                                  </div>
                                  <div class="d-flex justify-content-between mb-2">
                                      <span class="fw-bold">❌ Rejected</span>
                                      <span class="fw-bold">
                                          {{ $buyerDetails->where('mhi_status_id', '2')->count() > 0
                                              ? $buyerDetails->where('mhi_status_id', '2')->count() .
                                                  ' | ₹ ' .
                                                  number_format($buyerDetails->sum('mhi_rej_amount'), 2)
                                              : '' . ' | ₹ ' . number_format($buyerDetails->sum('mhi_rej_amount'), 2) }}
                                      </span>
                                  </div>
                                  <div class="d-flex justify-content-between">
                                      <span class="fw-bold">⏸️ Withheld</span>
                                      <span class="fw-bold">
                                          {{ $buyerDetails->where('mhi_status_id', '3')->count() > 0
                                              ? $buyerDetails->where('mhi_status_id', '3')->count() .
                                                  ' | ₹ ' .
                                                  number_format($buyerDetails->sum('mhi_wthhld_amount'), 2)
                                              : '' . ' | ₹ ' . number_format($buyerDetails->sum('mhi_wthhld_amount'), 2) }}
                                      </span>
                                  </div>

                                  <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                      <span class="fw-bold text-white">🔢 Total</span>
                                      <span class="fw-bold text-white">
                                          {{ $buyerDetails->count() }}
                                          |
                                          ₹
                                          {{ number_format(
                                              $buyerDetails->sum('mhi_amount') + $buyerDetails->sum('mhi_rej_amount') + $buyerDetails->sum('mhi_wthhld_amount'),
                                              2,
                                          ) }}
                                      </span>
                                  </div>
                              </div>
                          </div>
                      @endif
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="row">
      <div class="col-xl-12">
          <div class="col-6 mb-3">
              <h4>Claim Evaluation Details</h4>
          </div>
          <div class="col-sm-12 col-xl-12">
              <form action="{{ route('claimEvaluation.update', encrypt($claimId)) }}" id="plant" role="form"
                  method="POST" class='form-horizontal modelVer prevent-multiple-submit' files=true
                  enctype='multipart/form-data' accept-charset="utf-8">
                  {!! method_field('patch') !!}
                  @csrf
                  <div class="card">
                      <div class="card-header">
                      </div>
                      <div class="card-body">
                          <div class="dt-ext table-responsive  custom-scrollbar">
                              <table class="display table-bordered table-striped" id="export-button">
                                  <thead>
                                      <tr>
                                          <th scope="col">S.No.</th>
                                          <th scope="col">Vin chassis</th>
                                          <th scope="col">Claim Amount</th>
                                          <th scope="col">System Amount</th>
                                          <th scope="col">System Status</th>
                                          <th scope="col">System Remark</th>
                                          <th scope="col">PMA Status</th>
                                          <th scope="col" style="white-space: nowrap">PMA Approved
                                              Amount</th>
                                          <th scope="col" style="white-space: nowrap">PMA Rejected
                                              Amount</th>
                                          <th scope="col" style="white-space: nowrap">PMA Withheld
                                              Amount</th>

                                          <th scope="col">PMA Remark</th>
                                          @if (!Auth::user()->hasRole('MHI'))
                                              @if (Auth::user()->hasRole('AUDITOR') || count($stage) > 1)
                                                  <th scope="col" style="white-space: nowrap">
                                                      Auditor
                                                      Approved
                                                      Amount</th>
                                                  <th scope="col" style="white-space: nowrap">
                                                      Auditor
                                                      Rejected
                                                      Amount</th>
                                                  <th scope="col" style="white-space: nowrap">
                                                      Auditor
                                                      Withheld
                                                      Amount</th>
                                                  <th scope="col">Auditor Status</th>
                                                  <th scope="col">Auditor Remark</th>
                                                  <th scope="col">Date Of Payment</th>
                                              @endif
                                          @endif

                                          @if (!Auth::user()->hasRole('AUDITOR') && count($stage) > 2)
                                              <th scope="col" style="white-space: nowrap">
                                                  MHI
                                                  Approved
                                                  Amount</th>
                                              <th scope="col" style="white-space: nowrap">
                                                  MHI
                                                  Rejected
                                                  Amount</th>
                                              <th scope="col" style="white-space: nowrap">
                                                  MHI
                                                  Withheld
                                                  Amount</th>
                                              <th scope="col">MHI Status</th>
                                              <th scope="col">MHI Remark</th>
                                              <th scope="col">Date Of Payment</th>
                                          @endif
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @if (count($buyerDetails) > 0)
                                          @foreach ($buyerDetails as $buyerDetail)
                                              <tr>
                                                  @php
                                                      $sn = $loop->iteration;
                                                  @endphp
                                                  <input type="hidden" name="data[{{ $sn }}][sno]"
                                                      value="{{ $buyerDetail->s_no }}">
                                                  <th class="text-end">{{ $sn }}</th>
                                                  <td class="text-start">
                                                      {{ $buyerDetail->vin_chassis_no ?? 'NA' }}</td>
                                                  <td class="text-end">
                                                      {{ number_format($buyerDetail->eligible_incentive) ?? 'NA' }}
                                                  </td>
                                                  <td class="text-end">
                                                      {{ number_format($buyerDetail->approved_incentive) ?? 'NA' }}
                                                  </td>
                                                  <td class="text-start">
                                                      {{ $buyerDetail->status ?? 'NA' }}</td>
                                                  <td class="text-start">
                                                      {{ $buyerDetail->remark ?? 'NA' }}</td>

                                                  @if ($stage->where('status', 'D')->where('stage_id', '1')->count() == 1 || $stage->count() == 0)
                                                      @php
                                                          $approved_incentive =
                                                              $buyerDetail->pma_amount ??
                                                              $buyerDetail->approved_incentive;
                                                              
                                                      @endphp

                                                      <td class="text-start">
                                                          <select class="form-select"
                                                              name="data[{{ $sn }}][pma_status]"
                                                              style="width: 100px;" required onchange="upVal(this)">
                                                              <option value="" disabled selected>
                                                                  Please Select</option>

                                                              @php
                                                                  $syst_status_id =
                                                                      $buyerDetail->pma_status_id ??
                                                                      $buyerDetail->syst_status_id;
                                                              @endphp

                                                              @foreach ($pmaStatus as $stat)
                                                                  <option
                                                                      value="{{ $stat->id }}|{{ $stat->name }}"
                                                                      {{ $stat->id == $syst_status_id ? 'selected' : '' }}>
                                                                      {{ $stat->name }}
                                                                  </option>
                                                              @endforeach
                                                          </select>
                                                      </td>
                                                      <td class="text-end">
                                                          <input type="number"
                                                              name="data[{{ $sn }}][approved_amt]"
                                                              value="{{ $approved_incentive }}"
                                                              class="form-control-sm text-end"
                                                              placeholder="PMA Approved Amount" id="pmaApproved"
                                                              data-old-value="{{ $buyerDetail->eligible_incentive }}">
                                                      </td>
                                                      @if($buyerDetail->page_type==2)
                                                      <td class="text-end">
                                                          <input type="number"
                                                              name="data[{{ $sn }}][rejected_amt]"
                                                             value="{{ $buyerDetail->syst_status_id == 2 ? $buyerDetail->eligible_incentive ?? 0.0 : 0.0 }}"
                                                              class="form-control-sm text-end"
                                                              placeholder="PMA Rejected Amount" id="rejected_amt">
                                                      </td>
                                                      <td class="text-end">
                                                          <input type="number"
                                                              name="data[{{ $sn }}][withheld_amt]"
                                                            value="{{ $buyerDetail->syst_status_id == 3 ? $buyerDetail->eligible_incentive ?? 0.0 : 0.0 }}"

                                                              class="form-control-sm text-end"
                                                              placeholder="PMA Withheld Amount" id="pmaWithheld">
                                                      </td>

                                                      
                                                      @else
                                                      <td class="text-end">
                                                          <input type="number"
                                                              name="data[{{ $sn }}][rejected_amt]"
                                                              value="{{ $buyerDetail->pma_rej_amount ?? 0.0 }}"
                                                              class="form-control-sm text-end"
                                                              placeholder="PMA Rejected Amount" id="rejected_amt">
                                                      </td>
                                                      <td class="text-end">
                                                          <input type="number"
                                                              name="data[{{ $sn }}][withheld_amt]"
                                                              value="{{ $buyerDetail->pma_wthhld_amount ?? 0.0 }}"
                                                              class="form-control-sm text-end"
                                                              placeholder="PMA Withheld Amount" id="pmaWithheld">
                                                      </td>
                                                      @endif


                                                      <td class="text-start">

                                                          <textarea rows="3" cols="30" disabled>{{ $buyerDetail->pma_remarks ?? '' }}</textarea>
                                                          <select id="role_id1{{ $sn }}"
                                                              name="data[{{ $sn }}][pma_remark][]"
                                                              multiple="multiple" style="width: 100px;">
                                                              <option disabled>Please select</option>
                                                              @foreach ($remarks as $remark)
                                                                  <option
                                                                      value="{{ $remark->id }}|{{ $remark->remark }}">
                                                                      {{ $remark->remark }}
                                                                  </option>
                                                              @endforeach
                                                          </select>
                                                      </td>
                                                  @else
                                                      <td class="text-start">
                                                          {{ $buyerDetail->pma_status }}</td>
                                                      <td class="text-end">
                                                          {{ number_format($buyerDetail->pma_amount) }}
                                                      </td>
                                                      <td class="text-end">
                                                          {{ number_format($buyerDetail->pma_rej_amount) ?? 0.0 }}
                                                      </td>
                                                      <td class="text-end">
                                                          {{ number_format($buyerDetail->pma_wthhld_amount) ?? 0.0 }}
                                                      </td>

                                                      <td class="text-start">
                                                          {{ $buyerDetail->pma_remarks }}</td>
                                                  @endif
                                                  @if (!Auth::user()->hasRole('MHI'))
                                                      @if (count($stage) < 2)
                                                          @if (Auth::user()->hasRole('AUDITOR'))
                                                              <td>-</td>
                                                              <td>-</td>
                                                              <td>-</td>
                                                              <td>-</td>
                                                              <td>-</td>
                                                              <td>-</td>
                                                          @endif
                                                      @else
                                                          <td class="text-end">
                                                              {{ number_format($buyerDetail->auditor_amount) }}
                                                          </td>
                                                          <td class="text-end">
                                                              {{ number_format($buyerDetail->auditor_rej_amount) }}
                                                          </td>
                                                          <td class="text-end">
                                                              {{ number_format($buyerDetail->auditor_wthhld_amount) }}
                                                          </td>
                                                          <td class="text-start">
                                                              {{ $buyerDetail->auditor_status }}</td>
                                                          <td class="text-start">
                                                              {{ $buyerDetail->auditor_remarks }}</td>
                                                          <td class="text-start">
                                                              {{ $buyerDetail->auditor_date_of_payment }}
                                                          </td>
                                                      @endif
                                                  @endif

                                                  @if (count($stage) > 2 && !Auth::user()->hasRole('AUDITOR'))
                                                      @if (!Auth::user()->hasRole('AUDITOR') && count($stage) > 3)
                                                          <td class="text-end">
                                                              {{ number_format($buyerDetail->mhi_amount) }}</td>
                                                          <td class="text-end">
                                                              {{ number_format($buyerDetail->mhi_rej_amount) }}</td>
                                                          <td class="text-end">
                                                              {{ number_format($buyerDetail->mhi_wthhld_amount) }}</td>
                                                          <td class="text-start">{{ $buyerDetail->mhi_status }}</td>
                                                          <td class="text-start">{{ $buyerDetail->mhi_remarks }}</td>
                                                          <td class="text-start">
                                                              {{ $buyerDetail->auditor_date_of_payment }}</td>
                                                      @else
                                                          <td>-</td>
                                                          <td>-</td>
                                                          <td>-</td>
                                                          <td>-</td>
                                                          <td>-</td>
                                                          <td>-</td>
                                                      @endif
                                                  @endif

                                              </tr>
                                          @endforeach
                                      @else
                                          <td colspan="19" class="text-center">No Data Available
                                          </td>
                                      @endif
                                  </tbody>
                              </table>
                          </div>
                          @if ($stage->where('status', 'S')->where('stage_id', 1)->count() < 1)
                              @if (Auth::user()->hasRole('PMA'))
                                  <div class="mt-3">
                                      <label for="remarks">Remarks</label>
                                      <textarea name="remarks"
                                          value="@isset($stage[0]->revert_remarks)
                                                            {{ trim($stage[0]->revert_remarks) }}
                                                            @endisset"
                                          class="form-control" rows="3" placeholder="Enter your remarks here..." required
                                          aria-describedby="remarksHelp">
                                                                @isset($stage[0]->revert_remarks)
{{ trim($stage[0]->revert_remarks) }}
@endisset
                                                            </textarea>

                                      <small id="remarksHelp" class="form-text text-muted">Please
                                          provide any additional remarks here.</small>
                                  </div>


                                  <div class="col-12 mt-2">
                                      <div class="text-center">
                                          <button type="submit" class="btn btn-primary prevent-multiple-submit">Save
                                              As
                                              Draft</button>
                                          @if ($stage->where('stage_id', 1)->count() >= 1)
                                              <button type="button"
                                                  class="btn btn-warning btnApp prevent-multiple-submit">Submit To
                                                  Auditor</button>
                                          @endif
                                      </div>
                                  </div>
                              @endif
                          @endif
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
