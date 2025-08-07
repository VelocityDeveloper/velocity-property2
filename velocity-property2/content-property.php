<?php

/**
 * Post rendering content according to caller of get_template_part
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$status = get_post_meta( $post->ID, 'status', true );
$lokasi = get_post_meta( $post->ID, 'lokasi', true );
$agen = get_post_meta( $post->ID, 'agen', true );
$telepon_agen = get_post_meta( $post->ID, 'telepon_agen', true );
$luas_tanah = get_post_meta( $post->ID, 'luas_tanah', true );
$luas_bangunan = get_post_meta( $post->ID, 'luas_bangunan', true );
$jumlah_lantai = get_post_meta( $post->ID, 'jumlah_lantai', true );
$kamar_tidur = get_post_meta( $post->ID, 'kamar_tidur', true );
$kamar_mandi = get_post_meta( $post->ID, 'kamar_mandi', true );
$perabotan = get_post_meta( $post->ID, 'perabotan', true );
$kondisi_property = get_post_meta( $post->ID, 'kondisi_property', true );
$garasi = get_post_meta( $post->ID, 'garasi', true );
$jalur_telepon = get_post_meta( $post->ID, 'jalur_telepon', true );
$sertifikat = get_post_meta( $post->ID, 'sertifikat', true );
$daya_listrik = get_post_meta( $post->ID, 'daya_listrik', true );
?>

<article <?php post_class('block-primary mb-4'); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header">
        <?php do_action('justg_before_title');
        the_title('<h1 class="entry-title">', '</h1>'); ?>
        <div class="entry-meta mb-2">
            <?php //justg_posted_on(); ?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

    <div class="entry-content">

        <div class="border bg-white mb-3">
                <div class="row bg-light m-0 py-2">
                    <div class="col-md-8 h6 mb-2 mb-md-0">
                        <?php $args = array(
                            'orderby' => 'term_order',                          
                        );
                            $property_location = wp_get_object_terms( $post->ID,  'property-location', $args );
                            //echo '<pre>'.print_r($property_location,1).'</pre>'; 
                            if ( ! empty( $property_location ) ) {
                                if ( ! is_wp_error( $property_location ) ) {
                                    echo '<div class="property-location">';
                                        echo '<span class="pe-2"><i class="fa fa-map-o"></i></span>';
                                        foreach( array_reverse($property_location) as $term ) {
                                            echo '<span class="item-lokasi"><a  class="text-dark" href="' . esc_url( get_term_link( $term->slug, 'property-location' ) ) . '">' . esc_html( $term->name ) . '</a></span>'; 
                                        }
                                    echo '</div>';
                                }
                            }
                        ?>
                    </div>
                    <div class="col-md-4 h6 mb-0 text-md-end">
                        <?php echo velocity_harga(); ?>
                    </div>
                </div>
                <div class="row m-0 py-3">
                    <div class="col-12 mb-2">
                        <?php if(has_post_thumbnail()) { ?>
                            <img class="w-100" src="<?php the_post_thumbnail_url( 'full' ); ?> " />
                        <?php } ?>
                    </div>
                    <div class="col-12">
                        <small>Tayang sejak <?php the_time('d-m-Y'); ?> | Dilihat sebanyak <?php echo get_post_meta(get_the_ID(),'hit',true);?> kali</small>
                        <?php if($agen || $telepon_agen){ ?>
                            <div class="bg-agen p-3 text-dark my-2">
                                <?php if(!empty($agen)){ ?>
                                    <strong class="d-block mb-2"><?php echo $agen;?></strong>
                                <?php } if(!empty($telepon_agen)){
                                    // replace all except numbers
                                    $nowa    = $telepon_agen ? preg_replace('/[^0-9]/', '', $telepon_agen) : $telepon_agen;
                                    // replace 0 with 62 if first digit is 0
                                    if (substr($telepon_agen, 0, 1) == 0) {
                                        $nowa    = substr_replace($telepon_agen, '62', 0, 1);
                                    }
                                    
                                ?>
                                    <a class="rounded-0 py-2 px-4 bg-success text-white d-inline-block" target="_blank" href="https://wa.me/<?php echo $nowa; ?>?text=Hallo, saya mau tanya <?php echo get_the_title(); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16"><path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/></svg>
                                        <?php echo $telepon_agen;?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-6 pr-1">
                                <?php if(!empty($status)){ ?>
                                    <div class="mb-2"><strong>Status Properti:</strong> <?php echo $status; ?></div>
                                <?php } ?>
                                <?php if(!empty($luas_tanah)){ ?>
                                    <div class="mb-2"><strong>Luas Tanah:</strong> <?php echo $luas_tanah; ?></div>
                                <?php } ?>
                                <?php if(!empty($luas_bangunan)){ ?>
                                    <div class="mb-2"><strong>Luas Bangunan:</strong> <?php echo $luas_bangunan; ?></div>
                                <?php } ?>
                                <?php if(!empty($jumlah_lantai)){ ?>
                                    <div class="mb-2"><strong>Luas Lantai:</strong> <?php echo $jumlah_lantai; ?></div>
                                <?php } ?>
                                <?php if(!empty($kamar_tidur)){ ?>
                                    <div class="mb-2"><strong>Kamar Tidur:</strong> <?php echo $kamar_tidur; ?></div>
                                <?php } ?>
                                <?php if(!empty($kamar_mandi)){ ?>
                                    <div class="mb-2"><strong>Kamar Mandi:</strong> <?php echo $kamar_mandi; ?></div>
                                <?php } ?>
                                <?php if(!empty($perabotan)){ ?>
                                    <div class="mb-2"><strong>Perabotan:</strong> <?php echo $perabotan; ?></div>
                                <?php } ?>
                            </div>
                            <div class="col-6 pl-1">
                                <?php if(!empty($kondisi_property)){ ?>
                                    <div class="mb-2"><strong>Kondisi Properti:</strong> <?php echo $kondisi_property; ?></div>
                                <?php } ?>
                                <?php if(!empty($garasi)){ ?>
                                    <div class="mb-2"><strong>Garasi:</strong> <?php echo $garasi; ?></div>
                                <?php } ?>
                                <?php if(!empty($jalur_telepon)){ ?>
                                    <div class="mb-2"><strong>Jalur Telepon:</strong> <?php echo $jalur_telepon; ?></div>
                                <?php } ?>
                                <?php if(!empty($sertifikat)){ ?>
                                    <div class="mb-2"><strong>Sertifikat:</strong> <?php echo $sertifikat; ?></div>
                                <?php } ?>
                                <?php if(!empty($daya_listrik)){ ?>
                                    <div class="mb-2"><strong>Daya Listrik:</strong> <?php echo $daya_listrik; ?></div>
                                <?php } ?>
                                <?php if(!empty($lokasi)){ ?>
                                    <div class="mb-2"><strong>Lokasi Lengkap:</strong> <?php echo $lokasi; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr>
                        <?php echo get_the_content();?>
                    </div>
                </div>
            </div>

</div>

</article><!-- #post-## -->