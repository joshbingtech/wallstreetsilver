<div class="footer py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3 my-2">
                <div class="outer">
                    <div class="middle">
                        <div>
                            <h4 class="font-weight-light"> Contact </h4>
                            <table class="table-contact">
                                @foreach ($contacts as $contact)
                                    <tr>
                                        <td><img class="avatar" src="{{ asset($contact['thumbnail']) }}" /></td>
                                        <td><a href="{{ $contact['contact_link'] }}" class="contact-link" target="_blank"> {{ $contact['name'] }} </a></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 my-2">
                <div class="outer">
                    <div class="middle">
                        <div>
                            <h4 class="text-center font-weight-light"> Wall Street Silver. We just like Silver. </h4>
                            <h6 class="text-center font-weight-light"> Join Our <br/> Community, Ape! </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 my-2">
            <div class="jcarousel" style="width:100%;">
                <ul>
                    @foreach ($supporters as $supporter)
                        <li><a href="{{ $supporter['url'] }}"><img src="{{ asset($supporter['src']) }}" /></a></li>
                    @endforeach
                </ul>
            </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{ asset('plugins/jcarousel.min.js') }}"></script>
    <script src="{{ asset('js/footer.js') }}"></script>
@endpush
