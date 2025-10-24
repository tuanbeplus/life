<svg
    viewBox="0 0 64 71"
    class="svg-clip"
    width="64px"
    height="71px"
>
    <defs>
        <clipPath id="profilePicClip">
            <path
                d="M32.428,1C40.541,0.983 62.579,4.405 63.767,28.323C64.955,52.24 58.011,61.681 53,66.5C49.385,69.977 37.328,75.13 22,63C6.672,50.87 -4.468,24.773 4,11C10.23,0.867 24.316,1.017 32.428,1Z"
                style="fill:none;stroke:rgb(72,72,72);stroke-width:1px;"
            />
        </clipPath>
    </defs>
</svg>
<div class="our-team">
    <?php while( have_rows('team_members', 'option') ): the_row() ?>
        <a
            class="-member"
            <?php if ($linkedin = get_sub_field('linkedin')): ?>
                href="<?= $linkedin ?>"
                target="_blank"
                rel="noopener noreferrer"
            <?php endif ?>
        >
            <header>
                <?php $img = get_sub_field('profile_pic') ?>
                <figure class="<?= $img ? '-has-pic' : '-placeholder' ?>">
                    <?php if ($img): ?>
                        <img
                            src="<?= $img['sizes']['thumbnail'] ?>" 
                        />
                    <?php else: ?>
                        <img
                            src="<?php echo get_template_directory_uri(); ?>/images/logos/life-on-white.svg"
                            loading="lazy"
                            decoding="async"
                            alt="Life logo"
                        />
                    <?php endif ?>
                </figure>
                <div>
                    <h3><?= get_sub_field('name') ?></h3>
                    <h4><?= get_sub_field('job_title') ?></h4>
                </div>
            </header>
            <article>
                <?= get_sub_field('description') ?>
            </article>
            <footer>
                <?php if ($linkedin): ?>
                    <div class="-link">
                        <span class="-icon">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="2em"
                                height="2em"
                                viewBox="0 0 20 20"
                            >
                                <path
                                id="Linkedin"
                                d="M18,0a2,2,0,0,1,2,2V18a2,2,0,0,1-2,2H2a2,2,0,0,1-2-2V2A2,2,0,0,1,2,0ZM6.937,7.364H4.25V16H6.937Zm6.84-.215a2.824,2.824,0,0,0-2.542,1.395H11.2V7.364H8.622V16h2.685V11.727c0-1.126.215-2.217,1.613-2.217,1.378,0,1.4,1.288,1.4,2.29V16H17V11.263C17,8.938,16.5,7.149,13.777,7.149ZM5.566,3A1.564,1.564,0,1,0,7.132,4.564,1.565,1.565,0,0,0,5.566,3Z"
                                fill="currentColor"
                                fill-rule="evenodd"
                                />
                            </svg>
                        </span>
                        <p>Linkedin</p>
                    </div>
                <?php endif ?>
            </footer>
        </a>
    <?php endwhile ?>
</div>