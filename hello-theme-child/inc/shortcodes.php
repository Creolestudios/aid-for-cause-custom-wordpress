<?php

include_once('twitteroauth/twitteroauth.php');
// Twitter Tweeet caraousal shortcode
//add_shortcode('tweeter_feed_caraousal', 'get_latest_three_tweeter_feed');

function get_latest_three_tweeter_feed()
{
    ob_start();
    $twitter_customer_key           = (!empty(get_field('customer_key','option')))?get_field('customer_key','option'):get_field('customer_key','option');
    $twitter_customer_secret           = (!empty(get_field('customer_secret_key','option')))?get_field('customer_secret_key','option'):get_field('customer_secret_key','option');
    $twitter_access_token           = (!empty(get_field('twitter_access_token','option')))?get_field('twitter_access_token','option'):get_field('twitter_access_token','option');
    $twitter_access_token_secret           = (!empty(get_field('twitter_access_token_secret','option')))?get_field('twitter_access_token_secret','option'):get_field('twitter_access_token_secret','option');
    $twitter_image = get_field('twitter_image', 'option');

    $connection = new TwitterOAuth($twitter_customer_key, $twitter_customer_secret, $twitter_access_token, $twitter_access_token_secret);
    $connection->setApiVersion( '2' );
    $my_tweets = $connection->get('statuses/user_timeline', array('screen_name' => 'Khalsa_Aid', 'count' => 3, 'exclude_replies' => false));
    $followerNum = $my_tweets[0]->user->followers_count;
    $userScreenName = $my_tweets[0]->user->screen_name;
?>
    <section class="skyBlue-bg twitter-section">
        <div class="container">
            <div class="row">

                <div class="col-sm-3">
                    <div class="left-icon">
                        <p>
                            <?php
                            
                            if (!empty($twitter_image)) : ?>
                                <img src="<?php echo esc_url($twitter_image['url']); ?>" />
                            <?php endif; ?>
                        </p>
                        
                        <p class="follower_count"><?php echo $followerNum; ?></p>
                        <h3>
                            <a href="https://twitter.com/khalsa_aid" target="_blank" style="color: #fff;" title="Follow Us On Twitter"><?php echo '@' . $userScreenName; ?></a>
                        </h3>
                    </div>
                </div>

                <div class=" col-sm-9">

                    <div id="carousel-background-twitter" class="carousel slide" style="margin-top:25px">
                        <div class=" latest-article-slider tweets-rotator">
                            <div class="article-block-main-outer swiper-container country-slider">
                                <div class="swiper-wrapper">
                                    <?php
                                    if (isset($my_tweets->errors)) {
                                        echo 'Error :' . $my_tweets->errors[0]->code . ' - ' . $my_tweets->errors[0]->message;
                                    } else {
                                        foreach ($my_tweets as $media) {
                                    ?>
                                            <div class="loopdata swiper-slide">

                                                <p><?php echo $text = $media->text; ?></p>

                                                <span class="spantime">
                                                    <i class="fa fa-clock-o"></i>
                                                    <time class="timeago" datetime="<?php echo $created_at = $media->created_at; ?>"><?php echo $created_at = $media->created_at; ?></time>
                                                </span>

                                                <span>
                                                <img src="<?php echo get_home_url(); ?>/wp-content/uploads/2022/09/repeat.svg" />
                                                    <?php echo $retweet_count = $media->retweet_count; ?>
                                                </span>

                                                <span>
                                                    <i class="fa fa-heart"></i>
                                                    <?php echo $favorite_count = $media->favorite_count; ?>
                                                </span>


                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
    </section>
<?php
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}
