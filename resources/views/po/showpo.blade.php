@extends('layouts.app')

@section('scripts')
<script type="text/javascript">
    function confirmArchive() {
        return confirm('Are you sure you want to archive this PO?');
    }
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ url('/po/partialinv') }}"><- Back to Open POs</a>
                </div>

                <div class="panel-body">
                    <!-- Archive PO Button -->

			<form id="archive-form" method="POST" action="{{ url('/po/archive/'.$poinfo[0]->PONum) }}" onsubmit="return confirmArchive()">
                        <input type="hidden" name="ponum" value="{{ $poinfo[0]->PONum }}">
                        <button type="submit" class="btn btn-warning">Archive PO</button>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

                    </form>
                    <br>
                    <a href="{{ url('/orders/'.$poinfo[0]->OrderID) }}">Sales Order</a>
                    @php
                        $lastpo = 0;
                        $count = 0;
                        $index = 0;
                    @endphp

                    @foreach ($podetails as $podet)
                        @if ($podet->PONum != $lastpo)
                            @if ($count > 0)
                                </table>
                            @endif
                            <br>
                            <table class="table">
                                <tr>
                                    <th>Vendor</th>
                                    <th>E-mail</th>
                                    <th>PO Num</th>
                                    <th>Created Date</th>
                                    <th>Created By</th>
                                </tr>
                                <tr>
                                    <td>{{ $poinfo[$count]->Vendor }}</td>
                                    <td>{{ $vendorinfo[0]->Email }}</td>
                                    <td>{{ $podet->PONum }}</td>
                                    <td>{{ $poinfo[0]->CreatedDate }}</td>
                                    <td>{{ $poinfo[0]->createdby }}</td>
                                </tr>
                            </table>

                            <form method="POST" action="{{ url('/po/shipped/'.$podet->PONum) }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <input type="hidden" name="ponum" value="{{ $podet->PONum }}">

                                <table class="table table-condensed">
                                    <tr>
                                        <th>Info</th>
                                        <th>Billing</th>
                                        <th>Shipping</th>
                                    </tr>
                                    <tr>
                                        <td><strong>Company Name</strong></td>
                                        <td>FactoryExpress</td>
                                        <td>{{ $poinfo[$count]->ShippingCompanyName }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>First Name</strong></td>
                                        <td>Accounts</td>
                                        <td>{{ $poinfo[$count]->ShippingFirstName }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Last Name</strong></td>
                                        <td>Payable</td>
                                        <td>{{ $poinfo[$count]->ShippingLastName }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address1</strong></td>
                                        <td>8201 E Pacific Pl, Ste 603-604</td>
                                        <td>{{ $poinfo[$count]->ShippingAddress1 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address2</strong></td>
                                        <td></td>
                                        <td>{{ $poinfo[$count]->ShippingAddress2 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>City</strong></td>
                                        <td>Denver</td>
                                        <td>{{ $poinfo[$count]->ShippingCity }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>State</strong></td>
                                        <td>Colorado</td>
                                        <td>{{ $poinfo[$count]->ShippingState }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>PostalCode</strong></td>
                                        <td>80231</td>
                                        <td>{{ $poinfo[$count]->ShippingPostalCode }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Country</strong></td>
                                        <td>USA</td>
                                        <td>{{ $poinfo[$count]->ShippingCountry }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone Number</strong></td>
                                        <td>505-247-3232</td>
                                        <td>{{ $poinfo[$count]->ShippingPhoneNumber }}</td>
                                    </tr>
                                </table>
                                <table class="table table-condensed">
                                    <tr>
                                        <td width="175"><strong>Shipping Method:</strong></td>
                                        <td><strong>{{ $poinfo[$count]->ShippingMethod }}</strong></td>
                                        <td><b>Cart #: {{ $poinfo[0]->OrderID }}</b></td>
                                    </tr>
                                </table>
                                <table class="table table-condensed">
                                    @php $lastdate = ''; @endphp

                                    @foreach ($poshipped as $shipped)
                                        @if ($lastdate == $shipped->ShippedDate)
                                            <tr>
                                                <td></td>
                                                <td>{{ $shipped->ProductCode }}</td>
                                                <td>{{ $shipped->ProductName }}</td>
                                                <td>{{ $shipped->Quantity }}</td>
                                                <td><input type="date" name="{{ $shipped->invoicenum.$shipped->ProductCode.'shippeddate' }}" value="{{ $shipped->ShippedDate }}"></td>
                                                <td>
                                                    <button type="submit" class="btn btn-success btn-xs" name="update" value="{{ $shipped->ProductCode }}">
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <th>Invoice # {{ $shipped->invoicenum }}</th>
                                                <th>Product Code</th>
                                                <th>Product Description</th>
                                                <th>Shipped</th>
                                                <th>Shipped Date</th>
                                                <th>
                                                    <input type="hidden" name="invoicenum" value="{{ $shipped->invoicenum }}">
                                                    <button type="submit" name="quickbooks" value="{{ $shipped->invoicenum }}" class="btn btn-primary btn-xs">QB</button>
                                                    @if ($shipped->sent == 1)
                                                        <button type="submit" name="button" value="{{ $shipped->invoicenum }}" class="btn btn-danger btn-xs">Resend</button>
                                                    @else
                                                        <button type="submit" name="button" value="{{ $shipped->invoicenum }}" class="btn btn-primary btn-xs">Send</button>
                                                    @endif
                                                </th>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>{{ $shipped->ProductCode }}</td>
                                                <td>{{ $shipped->ProductName }}</td>
                                                <td>{{ $shipped->Quantity }}</td>
                                                <td><input type="date" name="{{ $shipped->invoicenum.$shipped->ProductCode.'shippeddate' }}" value="{{ $shipped->ShippedDate }}"></td>
                                                <td>
                                                    <button type="submit" class="btn btn-success btn-xs" name="update" value="{{ $shipped->ProductCode }}">
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                        @php $lastdate = $shipped->ShippedDate; @endphp
                                    @endforeach
                                </table>

                                <table class="table table-condensed">
                                    <tr>
                                        <th>Product Code</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Options</th>
                                        <th>Shipped</th>
                                        <th>Shipped Date</th>
                                    </tr>
                                    @php $index++; @endphp
                                    <tr>
                                        <td>{{ $podet->ProductCode }}</td>
                                        <td>{{ $podet->ProductName }}</td>
                                        <td>{{ $podet->Quantity }}</td>
                                        <td>{{ $podet->Cost }}</td>
                                        <td>{{ $podet->Options }}</td>
                                        <td><input type="text" maxlength="4" size="4" value="{{ $podet->Shipped }}" name="{{ $index.'shipped' }}"></td>
                                        <td><input type="date" name="{{ $index.'shippeddate' }}"></td>
                                    </tr>

                                    @php
                                        $count++;
                                        $lastpo = $podet->PONum;
                                    @endphp
                        @endif
                    @endforeach

                    @if ($poinfo[0]->Vendor == 'Inventory')
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right">
                                <button type="submit" name="button" value="inventory" class="btn btn-primary btn-xs">Save</button>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right">
                                <button type="submit" name="button" value="dropshipped" class="btn btn-primary btn-xs">Save</button>
                            </td>
                        </tr>
                    @endif
                            </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


