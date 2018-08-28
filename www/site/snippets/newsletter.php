<div id="newsletter">


    <div class="form">


        <div id="sib_embed_signup">


            <div class="forms-builder-wrapper">

            <input type="hidden" id="sib_embed_signup_lang" value="fr"> <input type="hidden" id="sib_embed_invalid_email_message" value="Cette adresse email n'est pas valide."> <input type="hidden" name="primary_type" id="primary_type" value="email">


                <form class="description" id="theform" name="theform" action="https://my.sendinblue.com/users/subscribeembed/js_id/3lkpg/id/1" onsubmit="return false;">
                <input type="hidden" name="js_id" id="js_id" value="3lkpg"><input type="hidden" name="listid" id="listid" value="4"><input type="hidden" name="from_url" id="from_url" value="yes"><input type="hidden" name="hdn_email_txt" id="hdn_email_txt" value="">


                    <div class="sib-container rounded ui-sortable" >

                    <input type="hidden" name="req_hid" id="req_hid" value="" >
                    <div class="view-messages" > </div>
                    <!-- an email as primary -->


                        <div class="primary-group email-group forms-builder-group ui-sortable" style="">


                            <div class="row mandatory-email" >


                                <!-- <div class="field">
                                  <div>FIRST NAME</div><input type="text" name="NOM" id="NOM" value="" >
                                </div>


                                <div class="field">
                                  <div>LAST NAME</div><input type="text" name="PRENOM" id="PRENOM" value="" >
                                </div>
 -->

                                <div class="field">
                                  <div><?= l::get('subscribe') ?></div><input type="text" name="email" id="email" value="" >
                                </div>


                                <div style="clear:both;"></div>


                                <div class="hidden-btns">
                                 <a class="btn move" href="#"><i class="fa fa-arrows"></i></a><br> <!--<a class="btn btn-danger delete" href="#"><i class="fa fa-trash-o fa-inverse"></i></a>-->
                                </div>


                            </div>

                        </div>


                    </div>


                <div class="captcha forms-builder-group" style="display: none;">
                <div class="row"><div id="gcaptcha" ></div></div>
                </div>


                <div class="byline" > <button class="button editable " type="submit" data-editfield="subscribe"><?= l::get('submit') ?></div>


                </form>


            </div>


        </div>



    </div>

<script type="text/javascript"> var sib_prefix = 'sib'; var sib_dateformat = 'dd-mm-yyyy'; </script>
<script type='text/javascript' src='https://my.sendinblue.com/public/theme/version4/assets/js/src/subscribe-validate.js?v=1528114688'></script>

    <div id="legal">
    By subscribing to Pop Noire newsletter, you agree to receive exclusive email updates. You may unsubscribe at anytime. For any questions, please <?= html::email('contact@popnoire.com', 'contact us') ?>.
    </div>

</div>
