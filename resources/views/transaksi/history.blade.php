                                <div class="col-lg-6 col-md-12">
                                  <div class="bs-callout-danger callout-border-left callout-bordered mt-1 p-1">
                                    @if (!$empty_batch && $active_batch->latestStat())
                                    <h4>Status Terakhir</h4>
                                    <table>
                                      <tr>
                                        <td width="65%">
                                          <b class="text-danger">{{ $active_batch->latestStat()->status() }}</b><br>
                                          @if (isset($active_batch->latestStat()['rejectReason']))
                                          <span class="font-small-3">{{ $active_batch->latestStat()['rejectReason']['reason']->content }}</span>
                                          @endif
                                        </td>
                                        <td>
                                          <code style="padding: 0;">{{ $active_batch->latestStat()->updated_at }}</code><br>
                                          <span class="font-small-3">Oleh: {{ $active_batch->latestStat()->submitter->name }} / {{ $active_batch->latestStat()->submitter->username }}</span>
                                        </td>
                                      </tr>
                                    </table>
                                    <br>
                                    @endif
                                    <h4>Histori Batch</h4>
                                    <table>
                                      @forelse($batch_history as $hist)
                                      <tr>
                                        <td><b class="text-danger">{{ $hist->status() }}</b> 
                                          @if ($hist['stat'] != "1" && $hist['stat'] != "0")
                                          <code>({{ $hist['total'] }}x)</code>
                                          @endif
                                        </td>
                                        <td>| <code>{{ $hist['tgl'] }}</code></td>
                                      </tr>
                                      @empty
                                      <code>Belum ada Histori batch terbaru.</code>
                                      @endforelse
                                    </table>
                                  </div>
                                </div>