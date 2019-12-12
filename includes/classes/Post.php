<?php  
	class Post
	{
		private $user_obj;
		private $con;

		public function __construct($con,$user)
		{
			$this->con=$con;
			$this->user_obj=new User($con,$user);
		}

		public function submitPost($body, $user_to,$imageName)
		{
			$body=strip_tags($body); //Removes HTML Tags
			$body=mysqli_real_escape_string($this->con,$body); //Allowed Single Quote (')' in String
			$check_empty=preg_replace('/\s+/', '', $body); //Remove all Spaces

			if($check_empty != "")
			{
				//Project Version 8 (For youtube link)
				//For Single video
				$body_array=preg_split("/\s+/", $body); //Split spaces

				foreach($body_array as $key => $value) //Key stores index and value stores data
				{
					if(strpos($value, "www.youtube.com/watch?v=") !== false) //Compare with data type
					{
						$link=preg_split("!&!", $value); //Split based on & (for playlist)
						$value=preg_replace("!watch\?v=!", "embed/", $link[0]);
						$value="<br> <iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe> <br>";
						$body_array[$key]=$value;
					}
				}
				$body=implode(" ", $body_array); //Space seperated


				$date_added=date("Y-m-d H:i:s"); //Current Date and Time
				$added_by=$this->user_obj->getUsername(); //Get Username
				//If user is on Profile , Set user to none
				if($user_to == $added_by)
				{
					$user_to="none";
				}

				//Insert Post into Database
				$query=mysqli_query($this->con,"INSERT INTO posts VALUES('','$body','$added_by','$user_to','$date_added','no','no','0','$imageName')");
				$returned_id=mysqli_insert_id($this->con);

				//Insert Notifications
				if($user_to != 'none') 
				{
					$notification = new Notification($this->con, $added_by);
					$notification->insertNotification($returned_id, $user_to, "profile_post");
				}

				//Update Post Count to user table
				$num_post=$this->user_obj->getNumPost();
				$num_post++;
				$update_query=mysqli_query($this->con,"UPDATE users SET num_post='$num_post' WHERE username='$added_by'");

				//Project Version 8
				$stopWords= "a about above across after again against all almost alone along already
							 also although always among am an and another any anybody anyone anything anywhere are 
							 area areas around as ask asked asking asks at away b back backed backing backs be became
							 because become becomes been before began behind being beings best better between big 
							 both but by c came can cannot case cases certain certainly clear clearly come could
							 d did differ different differently do does done down down downed downing downs during
							 e each early either end ended ending ends enough even evenly ever every everybody
							 everyone everything everywhere f face faces fact facts far felt few find finds first
							 for four from full fully further furthered furthering furthers g gave general generally
							 get gets give given gives go going good goods got great greater greatest group grouped
							 grouping groups h had has have having he her here herself high high high higher
						     highest him himself his how however i im if important in interest interested interesting
							 interests into is it its itself j just k keep keeps kind knew know known knows
							 large largely last later latest least less let lets like likely long longer
							 longest m made make making man many may me member members men might more most
							 mostly mr mrs much must my myself n necessary need needed needing needs never
							 new new newer newest next no nobody non noone not nothing now nowhere number
							 numbers o of off often old older oldest on once one only open opened opening
							 opens or order ordered ordering orders other others our out over p part parted
							 parting parts per perhaps place places point pointed pointing points possible
							 present presented presenting presents problem problems put puts q quite r
							 rather really right right room rooms s said same saw say says second seconds
							 see seem seemed seeming seems sees several shall she should show showed
							 showing shows side sides since small smaller smallest so some somebody
							 someone something somewhere state states still still such sure t take
							 taken than that the their them then there therefore these they thing
							 things think thinks this those though thought thoughts three through
					         thus to today together too took toward turn turned turning turns two
							 u under until up upon us use used uses v very w want wanted wanting
							 wants was way ways we well wells went were what when where whether
							 which while who whole whose why will with within without work
							 worked working works would x y year years yet you young younger
							 youngest your yours z lol haha omg hey ill iframe wonder else like 
				             hate sleepy reason for some little yes bye choose";

				$stopWords=preg_split("/[\s,]+/", $stopWords); //Removes spaces
				
				$no_punctuation=preg_replace("/[^a-zA-Z 0-9]+/", "", $body); //Not letters and numbers

				if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false
					&& strpos($no_punctuation, "http") === false && strpos($no_punctuation, "youtube") === false)
				{
					//Convert users post (with punctuation removed) into array - split at white space
					$keywords = preg_split("/[\s,]+/", $no_punctuation);

					foreach($stopWords as $value) 
					{
						foreach($keywords as $key => $value2)
						{
							if(strtolower($value) == strtolower($value2))
								$keywords[$key] = "";
						}
					}

					foreach ($keywords as $value) 
					{
				    	$this->calculateTrend(ucfirst($value));
					}
				}

			}
		}

		public function calculateTrend($term)
		{
			if($term != '')
			{
				$query=mysqli_query($this->con,"SELECT * FROM trends WHERE title='$term'");

				if(mysqli_num_rows($query)==0)
					$insert_query=mysqli_query($this->con,"INSERT INTO trends(title,hits) VALUES('$term','1')");
				else
					$insert_query=mysqli_query($this->con,"UPDATE trends SET hits=hits+1 WHERE title='$term'");
			}
		}

		public function loadPostsFriends($data,$limit)
		{
			$page=$data['page'];
			$userLoggedIn=$this->user_obj->getUsername();

			if($page==1)
				$start=0;
			else
				$start=($page-1) * $limit;

			$str=""; //String to Return
			$data_qeury=mysqli_query($this->con,"SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");

			if(mysqli_num_rows($data_qeury) > 0)
			{
				$num_iterations=0; //Number of results checked (not necessarily posted)
				$count=1;

				while($row=mysqli_fetch_array($data_qeury))
				{
					$id=$row['id'];
					$body=$row['body'];
					$added_by=$row['added_by'];
					$date_time=$row['date_added'];
					$imagePath=$row['image'];

					//Prepare User_to string so it can be included if not posted to a user
					if($row['user_to'] == "none")
					{
						$user_to="";
					}
					else
					{
						$user_to_obj=new User($this->con,$row['user_to']);
						$user_to_name=$user_to_obj->getFirstAndLastName();
						$user_to="to <a href='".$row['user_to']."'>".$user_to_name."</a>";
					}

					//Check If user who posted have closed their account
					$added_by_obj=new User($this->con,$added_by);
					if($added_by_obj->isClosed())
					{
						continue;
					}

					$user_logged_obj=new User($this->con,$userLoggedIn);
					if($user_logged_obj->isFriend($added_by))
					{
						if($num_iterations++ < $start)
							continue;

						//Once 10 post is loaded, then break
						if($count > $limit)
							break;
						else
							$count++; 

						if($userLoggedIn == $added_by)
							$delete_button="<button class='delete_button btn-danger' id='post$id'>X</button>";
						else
							$delete_button="";

						$user_details_query=mysqli_query($this->con,"SELECT first_name,last_name,profile_pic FROM users WHERE username='$added_by'");
						$user_row=mysqli_fetch_array($user_details_query);
						$first_name=$user_row['first_name'];
						$last_name=$user_row['last_name'];
						$profile_pic=$user_row['profile_pic'];
						?>
						
						<script>
							function toggle<?php echo $id; ?>()
							{
								var target=$(event.target);
								if(!target.is("a") && !target.is("button"))
								{
									var element = document.getElementById("toggleComment<?php echo $id; ?>");
									if(element.style.display == "block")
										element.style.display="none";
									else
										element.style.display="block";	
								}	
							} 
						</script>
						
					<?php
						$comment_check=mysqli_query($this->con,"SELECT * FROM comments WHERE post_id='$id'");
						$comment_check_num=mysqli_num_rows($comment_check);

						//Time ago for the post
						$date_time_now=date("Y-m-d H:i:s");
						$start_date=new DateTime($date_time); //Date and Time of Post
						$end_date=new DateTime($date_time_now); //Current time and date
						$interval=$start_date->diff($end_date); //Difference between dates

						if($interval->y >= 1) //For Years
						{
							if($interval->y == 1)
								$time_message=$interval->y." year ago"; //1 Year Ago
							else
								$time_message=$interval->y." years ago"; //1+ Year Ago
						}
						else if($interval->m >= 1) //For Months
						{
							if($interval->d == 0)
							{
								$days=" ago";
							}
							else if($interval->d == 1)
							{
								$days=$interval->d." day ago";
							}
							else
							{
								$days=$interval->d." days ago";
							}
							if($interval->m == 1)
							{
								$time_message=$interval->m." month".$days;
							}
							else
							{
								$time_message=$interval->m." months".$days;
							}
						}
						else if($interval->d >= 1) //For Days
						{
							if($interval->d == 1)
							{
								$time_message="Yesterday";
							}
							else
							{
								$time_message=$interval->d." days ago";
							}
						}
						else if($interval->h >= 1) //For Hours 
						{
							if($interval->h == 1)
							{
								$time_message=$interval->h." hour ago";
							}
							else
							{
								$time_message=$interval->h." hours ago";
							}
						}
						else if($interval->i >= 1) //For Minutes 
						{
							if($interval->i == 1)
							{
								$time_message=$interval->i." minute ago";
							}
							else
							{
								$time_message=$interval->i." minutes ago";
							}
						}
						else //For Seconds 
						{
							if($interval->s < 30)
							{
								$time_message="Just Now";
							}
							else
							{
								$time_message=$interval->s." seconds ago";
							}
						}

						if($imagePath != "")
						{
							$imageDiv="<div class='postedImage'>
											<img src='$imagePath'>
										</div>";
						}
						else
							$imageDiv="";

						$str.="<div class='status_post' onclick='javascript:toggle$id()'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>
								<div class='posted_by' style='color:#ACACAC;'>
									<a href='$added_by'>$first_name $last_name</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp; $time_message
									$delete_button
								</div>
								<div id='post_body'>
									$body <br>
										$imageDiv
									<br><br>
								</div>
								<div class='newsfeedPostOptions'>
									Comments($comment_check_num)&nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' scrolling='no'>
									</iframe>
								</div>
							</div>
							<div class='post_comment' id='toggleComment$id' style='display: none;'>
								<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
							</div>
							<hr>";
					}
					?>
					<script>
						$(document).ready(function()
						{
							$('#post<?php echo $id; ?>').on('click',function()
							{
								bootbox.confirm("Are you sure! You want to delete this post?",function(result)
								{
									$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>",{result: result});
									if(result)
										location.reload();
								});
							});
						});
					</script>
					<?php
				}
				if($count > $limit)
				{
					$str.="<input type='hidden' class='nextPage' value='".($page+1)."'>
							<input type='hidden' class='noMorePosts' value='false'>";
				}
				else
				{
					$str.="<input type='hidden' class='noMorePosts' value='true'><p style='text-align:center;'> No more Posts to show!</p>";	
				}

			}
			echo $str;
		}

		public function loadProfilePosts($data,$limit)
		{
			$page=$data['page'];
			$profileUser=$data['profileUsername'];
			$userLoggedIn=$this->user_obj->getUsername();

			if($page==1)
				$start=0;
			else
				$start=($page-1) * $limit;

			$str=""; //String to Return
			$data_qeury=mysqli_query($this->con,"SELECT * FROM posts WHERE deleted='no' AND ((added_by='$profileUser' AND user_to='none') OR user_to='$profileUser') ORDER BY id DESC");

			if(mysqli_num_rows($data_qeury) > 0)
			{
				$num_iterations=0; //Number of results checked (not necessarily posted)
				$count=1;

				while($row=mysqli_fetch_array($data_qeury))
				{
					$id=$row['id'];
					$body=$row['body'];
					$added_by=$row['added_by'];
					$date_time=$row['date_added'];

						if($num_iterations++ < $start)
							continue;

						//Once 10 post is loaded, then break
						if($count > $limit)
							break;
						else
							$count++; 

						if($userLoggedIn == $added_by)
							$delete_button="<button class='delete_button btn-danger' id='post$id'>X</button>";
						else
							$delete_button="";

						$user_details_query=mysqli_query($this->con,"SELECT first_name,last_name,profile_pic FROM users WHERE username='$added_by'");
						$user_row=mysqli_fetch_array($user_details_query);
						$first_name=$user_row['first_name'];
						$last_name=$user_row['last_name'];
						$profile_pic=$user_row['profile_pic'];
						?>
						
						<script>
							function toggle<?php echo $id; ?>()
							{
								var target=$(event.target);
								if(!target.is("a") && !target.is("button"))
								{
									var element = document.getElementById("toggleComment<?php echo $id; ?>");
									if(element.style.display == "block")
										element.style.display="none";
									else
										element.style.display="block";	
								}	
							} 
						</script>
						
					<?php
						$comment_check=mysqli_query($this->con,"SELECT * FROM comments WHERE post_id='$id'");
						$comment_check_num=mysqli_num_rows($comment_check);



						//Time ago for the post
						$date_time_now=date("Y-m-d H:i:s");
						$start_date=new DateTime($date_time); //Date and Time of Post
						$end_date=new DateTime($date_time_now); //Current time and date
						$interval=$start_date->diff($end_date); //Difference between dates

						if($interval->y >= 1) //For Years
						{
							if($interval->y == 1)
								$time_message=$interval->y." year ago"; //1 Year Ago
							else
								$time_message=$interval->y." years ago"; //1+ Year Ago
						}
						else if($interval->m >= 1) //For Months
						{
							if($interval->d == 0)
							{
								$days=" ago";
							}
							else if($interval->d == 1)
							{
								$days=$interval->d." day ago";
							}
							else
							{
								$days=$interval->d." days ago";
							}
							if($interval->m == 1)
							{
								$time_message=$interval->m." month".$days;
							}
							else
							{
								$time_message=$interval->m." months".$days;
							}
						}
						else if($interval->d >= 1) //For Days
						{
							if($interval->d == 1)
							{
								$time_message="Yesterday";
							}
							else
							{
								$time_message=$interval->d." days ago";
							}
						}
						else if($interval->h >= 1) //For Hours 
						{
							if($interval->h == 1)
							{
								$time_message=$interval->h." hour ago";
							}
							else
							{
								$time_message=$interval->h." hours ago";
							}
						}
						else if($interval->i >= 1) //For Minutes 
						{
							if($interval->i == 1)
							{
								$time_message=$interval->i." minute ago";
							}
							else
							{
								$time_message=$interval->i." minutes ago";
							}
						}
						else //For Seconds 
						{
							if($interval->s < 30)
							{
								$time_message="Just Now";
							}
							else
							{
								$time_message=$interval->s." seconds ago";
							}
						}

						$str.="<div class='status_post' onclick='javascript:toggle$id()'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>
								<div class='posted_by' style='color:#ACACAC;'>
									<a href='$added_by'>$first_name $last_name</a> &nbsp;&nbsp;&nbsp;&nbsp; $time_message
									$delete_button
								</div>
								<div id='post_body'>
									$body <br><br><br>
								</div>
								<div class='newsfeedPostOptions'>
									Comments($comment_check_num)&nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' scrolling='no'>
									</iframe>
								</div>
							</div>
							<div class='post_comment' id='toggleComment$id' style='display: none;'>
								<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
							</div>
							<hr>";
					?>
					<script>
						$(document).ready(function()
						{
							$('#post<?php echo $id; ?>').on('click',function()
							{
								bootbox.confirm("Are you sure! You want to delete this post?",function(result)
								{
									$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>",{result: result});
									if(result)
										location.reload();
								});
							});
						});
					</script>
					<?php
				}
				if($count > $limit)
				{
					$str.="<input type='hidden' class='nextPage' value='".($page+1)."'>
							<input type='hidden' class='noMorePosts' value='false'>";
				}
				else
				{
					$str.="<input type='hidden' class='noMorePosts' value='true'><p style='text-align:center;'> No more Posts to show!</p>";	
				}

			}
			echo $str;
		}

		public function getSinglePost($post_id)
		{
			$userLoggedIn=$this->user_obj->getUsername();

			$opened_query=mysqli_query($this->con,"UPDATE notifications SET opened='yes' WHERE user_to='$userLoggedIn' AND link LIKE '%=$post_id'");

			$str=""; //String to Return
			$data_query=mysqli_query($this->con,"SELECT * FROM posts WHERE deleted='no' AND id='$post_id'");

			if(mysqli_num_rows($data_query) > 0)
			{
				$row=mysqli_fetch_array($data_query);
				$id=$row['id'];
				$body=$row['body'];
				$added_by=$row['added_by'];
				$date_time=$row['date_added'];

				//Prepare User_to string so it can be included if not posted to a user
				if($row['user_to'] == "none")
				{
					$user_to="";
				}
				else
				{
					$user_to_obj=new User($this->con,$row['user_to']);
					$user_to_name=$user_to_obj->getFirstAndLastName();
					$user_to="to <a href='".$row['user_to']."'>".$user_to_name."</a>";
				}

				//Check If user who posted have closed their account
				$added_by_obj=new User($this->con,$added_by);
				if($added_by_obj->isClosed())
				{
					return;
				}

				$user_logged_obj=new User($this->con,$userLoggedIn);
				if($user_logged_obj->isFriend($added_by))
				{ 

					if($userLoggedIn == $added_by)
						$delete_button="<button class='delete_button btn-danger' id='post$id'>X</button>";
					else
						$delete_button="";

					$user_details_query=mysqli_query($this->con,"SELECT first_name,last_name,profile_pic FROM users WHERE username='$added_by'");
					$user_row=mysqli_fetch_array($user_details_query);
					$first_name=$user_row['first_name'];
					$last_name=$user_row['last_name'];
					$profile_pic=$user_row['profile_pic'];
					?>
					
					<script>
						function toggle<?php echo $id; ?>()
						{
							var target=$(event.target);
							if(!target.is("a") && !target.is("button"))
							{
								var element = document.getElementById("toggleComment<?php echo $id; ?>");
								if(element.style.display == "block")
									element.style.display="none";
								else
									element.style.display="block";	
							}	
						} 
					</script>
					
					<?php
					
					$comment_check=mysqli_query($this->con,"SELECT * FROM comments WHERE post_id='$id'");
					$comment_check_num=mysqli_num_rows($comment_check);

					//Time ago for the post
					$date_time_now=date("Y-m-d H:i:s");
					$start_date=new DateTime($date_time); //Date and Time of Post
					$end_date=new DateTime($date_time_now); //Current time and date
					$interval=$start_date->diff($end_date); //Difference between dates

					if($interval->y >= 1) //For Years
					{
						if($interval->y == 1)
							$time_message=$interval->y." year ago"; //1 Year Ago
						else
							$time_message=$interval->y." years ago"; //1+ Year Ago
					}
					else if($interval->m >= 1) //For Months
					{
						if($interval->d == 0)
						{
							$days=" ago";
						}
						else if($interval->d == 1)
						{
							$days=$interval->d." day ago";
						}
						else
						{
							$days=$interval->d." days ago";
						}
						if($interval->m == 1)
						{
							$time_message=$interval->m." month".$days;
						}
						else
						{
							$time_message=$interval->m." months".$days;
						}
					}
					else if($interval->d >= 1) //For Days
					{
						if($interval->d == 1)
						{
							$time_message="Yesterday";
						}
						else
						{
							$time_message=$interval->d." days ago";
						}
					}
					else if($interval->h >= 1) //For Hours 
					{
						if($interval->h == 1)
						{
							$time_message=$interval->h." hour ago";
						}
						else
						{
							$time_message=$interval->h." hours ago";
						}
					}
					else if($interval->i >= 1) //For Minutes 
					{
						if($interval->i == 1)
						{
							$time_message=$interval->i." minute ago";
						}
						else
						{
							$time_message=$interval->i." minutes ago";
						}
					}
					else //For Seconds 
					{
						if($interval->s < 30)
						{
							$time_message="Just Now";
						}
						else
						{
							$time_message=$interval->s." seconds ago";
						}
					}
					$str.="<div class='status_post' onclick='javascript:toggle$id()'>
							<div class='post_profile_pic'>
								<img src='$profile_pic' width='50'>
							</div>
							<div class='posted_by' style='color:#ACACAC;'>
								<a href='$added_by'>$first_name $last_name</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp; $time_message
								$delete_button
							</div>
							<div id='post_body'>
								$body <br><br><br>
							</div>
							<div class='newsfeedPostOptions'>
								Comments($comment_check_num)&nbsp;&nbsp;&nbsp;
								<iframe src='like.php?post_id=$id' scrolling='no'>
								</iframe>
							</div>
						</div>
						<div class='post_comment' id='toggleComment$id' style='display: none;'>
							<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
						</div>
						<hr>";
				?>
					<script>
						$(document).ready(function()
						{
							$('#post<?php echo $id; ?>').on('click',function()
							{
								bootbox.confirm("Are you sure! You want to delete this post?",function(result)
								{
									$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>",{result: result});
									if(result)
										location.reload();
								});
							});
						});
					</script>
				<?php
				}
				else
				{
					echo "<p>You cannot see this post! Because you are not friend with this user.</p>";
					return;
				}
			}
			else
			{
				echo "<p>No post found! If you clicked a link, it maybe broken</p>";
				return;
			}
			echo $str;
		}
	}

?>