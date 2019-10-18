<?php

class DateTimeView {

	/**
	 * Renders the time and date
	 */
	public function show() {
		$now = new DateTime('now', new DateTimeZone('Europe/Berlin'));

		$day = $now->format('l');
		$dayDate = $now->format('jS');
		$month = $now->format('F ');
		$year = $now->format('Y');
		$hourMinSec = $now->format('H:i:s');

		// Pringring exemple: Thursday, the 12th of September 2019, The time is 17:03:17
		$timeString = $day . ', the ' . $dayDate . ' of ' . $month . $year . ', The time is ' . $hourMinSec;

		return '<p>' . $timeString . '</p>';
	}
}