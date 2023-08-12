

@isset($settings['alerts_status'])@if( $settings['alerts_status'] == "true") 
<div class="alert @if(isset($settings['alerts_type']))alert-{{ $settings['alerts_type'] }}@else alert-primary @endif alert-dismissible fade show" role="alert" style="margin-top: 80px;">
    <span class="alert-inner--icon"> <i class='bx bx-info-circle' ></i> </span>
    <span class="alert-inner--text"><strong>@if(isset($settings['alert_title'])){{ $settings['alert_title'] }}@else Alert! @endif</strong> @if(isset($settings['alert_desc'])){{ $settings['alert_desc'] }}@else This is the alert description @endif</span>
    
    @isset($settings['alerts_closable'])@if( $settings['alerts_closable'] == "true") 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> @endif @endisset
    <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@endisset