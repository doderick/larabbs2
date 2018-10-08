<?php

namespace App\Models\Traits;

use App\Models\Topic;

trait ViewCountHelper
{
	public function syncTopicViewCount()
	{
		$topics = Topic::all();
		foreach ($topics as $topic) {
			$topic->view_count = $topic->visits()->count();
			$topic->save();
		}
	}
}