<div class="content-banner -centered-quote">
    <h2 class="-eyebrow-heading"><?= $eyebrow_heading ?></h2>
    <blockquote cite="https://www.huxley.net/bnw/four.html">
        <p>
            <svg width="0.65em" height="0.65em" viewBox="0 0 17 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                <path d="M14.631,6.929L12.156,6.929L12.156,4.949C12.156,3.857 13.044,2.969 14.136,2.969L14.384,2.969C14.795,2.969 15.126,2.638 15.126,2.227L15.126,0.742C15.126,0.331 14.795,0 14.384,0L14.136,0C11.402,0 9.187,2.215 9.187,4.949L9.187,12.373C9.187,13.192 9.852,13.857 10.672,13.857L14.631,13.857C15.451,13.857 16.116,13.192 16.116,12.373L16.116,8.413C16.116,7.594 15.451,6.929 14.631,6.929ZM5.723,6.929L3.248,6.929L3.248,4.949C3.248,3.857 4.136,2.969 5.228,2.969L5.475,2.969C5.887,2.969 6.218,2.638 6.218,2.227L6.218,0.742C6.218,0.331 5.887,0 5.475,0L5.228,0C2.493,0 0.279,2.215 0.279,4.949L0.279,12.373C0.279,13.192 0.944,13.857 1.764,13.857L5.723,13.857C6.542,13.857 7.207,13.192 7.207,12.373L7.207,8.413C7.207,7.594 6.542,6.929 5.723,6.929Z" style="fill:currentColor;fill-rule:nonzero;"/>
            </svg>
            <span><?= $large_quote ?></span>
            <svg width="0.6em" height="0.6em" viewBox="0 0 16 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                <path d="M1.484,6.929L3.958,6.929L3.958,8.908C3.958,10 3.071,10.888 1.979,10.888L1.731,10.888C1.32,10.888 0.989,11.219 0.989,11.63L0.989,13.115C0.989,13.527 1.32,13.857 1.731,13.857L1.979,13.857C4.713,13.857 6.928,11.643 6.928,8.908L6.928,1.485C6.928,0.665 6.263,0 5.443,0L1.484,0C0.664,0 -0.001,0.665 -0.001,1.485L-0.001,5.444C-0.001,6.264 0.664,6.929 1.484,6.929ZM10.392,6.929L12.867,6.929L12.867,8.908C12.867,10 11.979,10.888 10.887,10.888L10.64,10.888C10.228,10.888 9.897,11.219 9.897,11.63L9.897,13.115C9.897,13.527 10.228,13.857 10.64,13.857L10.887,13.857C13.621,13.857 15.836,11.643 15.836,8.908L15.836,1.485C15.836,0.665 15.171,0 14.351,0L10.392,0C9.572,0 8.907,0.665 8.907,1.485L8.907,5.444C8.907,6.264 9.572,6.929 10.392,6.929Z" style="fill:currentColor;fill-rule:nonzero;"/>
            </svg>
        </p>
        <cite><?= preg_replace(
			[
				'#Life\! flex#si',
				'#Life\!#si',
			],
			[
				'<i><em>Life!</em> flex</i>',
				'<em>Life!</em>',
			],
			$attribution
		) ?> - <a href="<?= $link_url ?>"><?= $link_text ?></a></cite>
    </blockquote>
    <div class="-button">
        <a
            href="<?= $button_url ?>"
            class="button"
        ><?= $button_text ?></a>
    </div>
</div>