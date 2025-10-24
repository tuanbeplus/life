<?php if (WP_DEBUG): ?>
  <h1>section-learn-about.php deprecated</h1>
<?php else: ?>
                                    <section class="section-learn-about-header bg-off-white curve-top">
                                      <svg-edge-curve-1></svg-edge-curve-1>
                                      <h2 class="text-center font-lgr wt-bold lh-tight"><?php echo apply_filters('the_brand', $heading); ?></h2>
                                    </section>
                                    <section class="section-learn-about bg-off-white overflow-hidden">
                                      <div class="center-frame">
                                        <?php if (is_array($tabs)): ?>
                                          <?php
                                            $tabNav = contentTabsNavProp($tabs);
                                            // dd($tabNav);
                                          ?>
                                          <content-tabs
                                            class="-tablet-head-nav-grid"
                                            :tabs="<?= vueProp($tabNav) ?>"
                                            :mobile-accordion="true"
                                          >
                                            <?php foreach ($tabs as $i => $tab): $slug = $tabNav[$i]['slug'] ?>
                                              <template #tab-<?= $i ?>>
                                                <div class="-content">
                                                  <div
                                                    class="tab-inner padded"
                                                    data-tab-number="<?= $slug ?>"
                                                    data-tab-set="learn-about"
                                                  >
                                                    <div class="inner">
                                                      <?php switch ($tab['content_type'] ?? null) {
                                                        case 'blocks':
                                                          echoTemplate('elements/block-list', ['blocks' => $tab['block_content']]);
                                                          break;
                                                        case 'flows':
                                                          echoTemplate('elements/pathways-flow', [
                                                            'group' => $slug,
                                                            'pathways' => $tab,
                                                          ]);
                                                          break;
                                                        case 'stepped':
                                                          echoTemplate('elements/stepped-listing', ['group' => $slug, 'stepped' => $tab]);
                                                          break;
                                                        case 'link':
                                                          echo '<div class="content formatted">' . apply_filters('the_content', $tab['content']) . '</div>';
                                                          break;
                                                      } ?>
                                                    </div>
                                                  </div>
                                                </div>
                                              </template>
                                            <?php endforeach ?>
                                          </content-tabs>
                                        <?php endif ?>
                                      </div>
                                    </section>
<?php endif ?>