<?php
$allLogs = Logs::find_all();

?>
<div class="page-header">
	<h1>Activity Logs</h1>
</div>
<div class="row">
	<div class="col-lg-12">
		<h2>Activity over the last 30 days</h2>
		<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
	</div>
	<div class="col-lg-12">
		<table class="table table-bordered table-striped">
		    <thead>
		    	<tr>
		    		<th width="15%">Date</th>
		    		<th width="15%">Title</th>
		    		<th width="45%" class="visible-lg visible-md">Description</th>
		    		<th width="15%">User</th>
		    		<th width="10%">IP</th>
		    	</tr>
		    </thead>
		    <tbody>
		    	<?php
		    	foreach ($allLogs AS $log) {
		    		$bookingDate = date('z', strtotime($log->date_created));
					$bookingsByDay[$bookingDate] = $bookingsByDay[$bookingDate] + 1;
					
		    		if (isset($log->userUID)) {
			    		$user = Students::find_by_uid($log->userUID);
			    	}
		    		
		    		if ($log->type == "info") {
			    		$class = "";
		    		} elseif ($log->type == "success") {
			    		$class = "success";
		    		} elseif ($log->type == "error") {
			    		$class = "danger";
		    		} else {
			    		$class = "warning";
		    		}
		    		
		    		$output  = "<tr class=\"" . $class . "\">";
		    		$output .= "<td>" . $log->date_created . "</td>";
		    		$output .= "<td>" . $log->title . "</td>";
		    		$output .= "<td>" . $log->description . "</td>";
		    		
		    		if (isset($user->uid)) {
			    		$url = "index.php?m=students&n=user.php&studentUID=" . $user->uid;
						$output .= "<td>" . "<a href=\"" . $url . "\">" . $user->fullDisplayName() . "</a></td>";
					} else {
						$output .= "<td>" . "<a href=\"" . $url . "\">" . "" . "</a></td>";
					}
		    		$output .= "<td>" . $log->ip . "</td>";
		    		$output .= "</tr>";
		    		
		    		echo $output;
		    	}
		    	
		    	//printArray($bookingsByDay);
		    	?>
		    </tbody>
		</table>
	</div>
</div>

<?php
// take the array $bookingsByDay and re order to friendly date names, and only the last 3o days
$totalDays = 30;

$i = 0;
do {
	$date = strtotime("-" . $i . " day");
	$friendlyDate = "'" . date('M d',$date) . "'";
	
	if ($bookingsByDay[date('z',$date)] <= 0) {
		$value = 0;
	} else {
		$value = $bookingsByDay[date('z',$date)];
	}
	
	$graphData[$friendlyDate] = $value;
	$i++;
} while ($i < $totalDays);
$graphData = array_reverse($graphData);
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'column'
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            xAxis: {
                categories: [<?php echo implode(",", array_keys($graphData)); ?>],
                title: {
                    text: null
                },
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Log Events'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ this.y;
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
            	enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Log Events',
                data: [<?php echo implode(",", $graphData);?>]
            }]
        });
    });
    
});
</script>

<script src="js/highcharts.js"></script>