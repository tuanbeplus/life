<div class="question -no-num" data-moderate-risk-section="region-1">
    <div class="form-group">
        <div class="label">Do you live in Victoria?</div>
        <div class="block-radio-group thirds">
            <div class="block-radio">
                <label class="option label">
                    <input type="radio" name="in_victoria" value="Yes" required>
                    <span class="option-label"><span>Yes I do</span></span>
                </label>
            </div>
            <div class="block-radio">
                <label class="option label">
                    <input type="radio" name="in_victoria" value="No">
                    <span class="option-label"><span>No I don't</span></span>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="question -no-num" data-moderate-risk-section="region-2">
    <div class="form-group">
        <label for="inp-region_search" class="label">Please type your suburb/postcode in here</label>
        <div class="accepted-region-search">
            <div class="-term-field">
                <input id="inp-region_search" type="text" />
                <div class="-loader">
                    <?= life_icon('loader', null, 'life-spin loading') ?>
                </div>
            </div>
            <div class="-min-height">
                <div class="-results block-radio-group thirds"></div>
                <div class="-message"></div>
            </div>
            <div class="-continue block-radio-group thirds hidden">
                <div class="block-radio">
                    <label class="option label">
                        <input type="radio" name="accepted_region" value="None">
                        <span class="option-label"><span class="-text">Continue</span></span>
                    </label>
                </div>
                <p class="-reset">
                    <span>Search again</span>
                    <?= life_icon('search') ?>
                </p>
            </div>
        </div>
    </div>
</div>