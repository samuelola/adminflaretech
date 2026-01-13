                  
                      
                      
                       @foreach($subscribers as $subscriber)

                       
                       <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="assets/images/users/user1.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">{{$subscriber->user->first_name}}{{$subscriber->user->last_name}}</h6>
                                <span class="text-sm text-secondary-light fw-medium">{{$subscriber->user->email}}</span>
                              </div>
                            </div>
                          </td>
                          <td>{{\Carbon\Carbon::parse($subscriber->created_at)->format('d/m/Y')}}</td>
                          <td>{{$subscriber->reference}}</td>
                          <td>{{$subscriber->gateway}}</td>
                          
                          
                          <td>
                             {{$subscriber->subscription->subscription_name ?? ''}}
                          </td>
                          <td>
                             {{$subscriber->amount}}
                          </td>
                          
                          
                          
                        </tr>
                       
                        
                        @endforeach
                        
                    