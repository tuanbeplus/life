<div class="question -no-num" data-moderate-risk-section="waist-measurement-exact">
    <div class="form-group">
        <h4 class="label wt-sb font-mdish lh-std">
            What is your waist measurement?
            <span class="tooltip fg-dark-grey">
                <i class="icon info"><?php echo life_icon('info-circle'); ?></i>
                <span class="content formatted">
                    Measure your waist below the ribs while standing (usually around the belly button)
                </span>
            </span>
        </h4>
        <p>
            Your waist measurement is in the lowest range.<br>
            To check your eligibility, we need more information.
        </p>
        <div class="label-line">
            <label for="wasit-measurement-exact">Waist (cm)</label>
        </div>
        <div class="input-submit">
            <input
                id="wasit-measurement-exact"
                type="number"
                name="waist_measurement_exact"
                min="1" max="120"
                maxlen="2"
                required
            />
            <button type="button" class="button" aria-label="Next question">
                <span class="life life-chevron-right"></span>
            </button>
        </div>
    </div>
</div>
