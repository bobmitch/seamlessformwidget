<?php
defined('CMSPATH') or die; // prevent unauthorized access



class Widget_form extends Widget {
	public function render() {

		
		/* echo "<p>" . $smtp_name . "</p>";
		echo "<p>" . $smtp_password . "</p>";
		echo "<p>" . $smtp_username . "</p>";
		echo "<p>" . $smtp_from . "</p>";
		echo "<p>" . $smtp_replyto . "</p>";
		echo "<p>" . $smtp_server . "</p>";
		echo "<p>" . $encryption . "</p>";
		echo "<p>" . $authenticate . "</p>"; */
		/* CMS::pprint_r ($this);
		exit(0); */
		//echo $this->options[0]->value;
		$myform = new Form(CMSPATH . "/widgets/form/" . $this->options[0]->value);
		if ($myform->is_submitted()):?>
			<?php 
			$myform->set_from_submit();
			$name = $myform->get_field_by_name('name')->default;
			if (!$myform->validate()) {
				CMS::Instance()->queue_message('Invalid form','danger', $_SERVER['HTTP_REFERER']);
			}
			$mail = new Mail();
			$mail->addAddress("bobmitch@gmail.com","Bob CMS Mitch");
			$mail->subject = "Test Contact Form Submission on CMSTEST";
			$mail->html = "<h1>well hello there sir from {$name}</h1>";
			$mail->send();
			// set redirect page from options
			$page = new Page();
			if ($page->load_from_id($this->options[1]->value[0])) {
				$url = $page->get_url();
				CMS::Instance()->queue_message('Form submitted','success',$url);
			}
			else {
				CMS::show_error('Failed to load redirect page in form widget');
			}
			?>
		<?php else: ?>
			<form method="POST" id="<?php echo Input::make_alias($this->title);?>_form_widget">
				<?php
				$myform->display_front_end();
				?>
			</form>

		<?php endif; 
	}
}