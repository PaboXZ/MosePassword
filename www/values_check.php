<?php
	error_reporting(0);
	for($i = 1; $i < 95; $i++)
	{
		$values[$i] = $i;
		$result[$i] = 0;
	}
	$range_bottom = 1;
	$max_count = 0;
	for($i = $range_bottom; $i < $range_bottom + 94; $i++)
	{
		for($j = $i; $j < $range_bottom + 94; $j++)
		{
			$box = ($i * $j) % 89;
			$result[$box]++;
		}
	}
	for($i = 1, $min_count = $result[$i]; $i < 95; $i++)
	{
		if($result[$i] < $min_count) $min_count = $result[$i];
		if($result[$i] > $max_count) $max_count = $result[$i];
	}
	echo "Bottom value: ".$range_bottom."<br>
		Top value: ".($range_bottom + 94)."<br>
		Minimum count: ".$min_count."<br>
		Maximum count: ".$max_count."<br>";
	for($i = 1; $i < 95; $i++)
	{
		echo $result[$i]."<br>";
	}

?>