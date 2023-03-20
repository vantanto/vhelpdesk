<div class="row">
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <x-dashboard.widget-ticket-total :label="'Requested'" :value="$tickets['requested']" :value_compare="$tickets['requested_lastmonth']" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <x-dashboard.widget-ticket-total :label="'Assigned'" :value="$tickets['assigned']" :value_compare="$tickets['assigned_lastmonth']" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <x-dashboard.widget-ticket-total :label="'Dept Requested'" :value="$tickets['requested_department']" :value_compare="$tickets['requested_department_lastmonth']" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <x-dashboard.widget-ticket-total :label="'Dept Assigned'" :value="$tickets['assigned_department']" :value_compare="$tickets['assigned_department_lastmonth']" />
    </div>
</div>