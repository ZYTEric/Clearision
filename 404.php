<?php get_header(); ?>
<style>
    nav.post_nav_bds{
        padding-bottom: 0 !important;
        margin-bottom: -13.6px;
    }
    .p404-col{
        padding-left: 0;
        padding-right: 0;
    }
    @media (min-width: 992px){
	    .p404-col{
	    	padding-left: .6em;
	        padding-right: .6em;
	    }
	    .p404-col:nth-child(1){
	    	padding-left: 0;
	    }
	    .p404-col:nth-child(3){
	        padding-right: 0;
	    }
	}
    .p404-col ul{
        list-style: none;
        list-style-image: none;
        list-style-type: none;
        padding-left: 0;
        margin: 0;
    }
    .p404-col ul li {
        padding: .3em .2em;
        border-bottom: solid 1px rgba(255,255,255,.2);
        white-space:nowrap;
        overflow:hidden;
        text-overflow: ellipsis;
        -o-text-overflow:ellipsis;
    }
    .p404-col .searchform{
        text-align: center;
    }
    .p404-col .searchform input#s{
        width: calc(100% - 60px);
    }
</style>
<div id="page-warp">
	<div id="content">
	    <div class="post_warp">
	    	<hgroup class="post_header">
	    		<h2 class="post_title"><a href="javascript:;">404 您查找的页面不存在</a></h2>
	    	</hgroup>
	    	<div class="post_content">
	    	    <p style="margin-bottom: 0">很抱歉，您要寻找的页面不存在或已被删除。请确认您访问的页面地址是否正确。</p>
	            <div class="container">
	                <div class="row">
	                    <div class="col-lg-4 col-md-12 p404-col"><?php dynamic_sidebar( 'clra_404_1' ); ?></div>
	                    <div class="col-lg-4 col-md-12 p404-col"><?php dynamic_sidebar( 'clra_404_2' ); ?></div>
	                    <div class="col-lg-4 col-md-12 p404-col"><?php dynamic_sidebar( 'clra_404_3' ); ?></div>
	                </div>
	            </div>
	    	</div>
	        <nav class="post_nav_bds">
	        	<a href="<?php echo $clrs_siteURL; ?>" rel="home" class="goHome">
	        		<i class="fa fa-home" aria-hidden="true">&nbsp; 返回首页</i>
	        	</a>
	        </nav>
	    </div>
	</div>
</div>
<?php get_footer(); ?>