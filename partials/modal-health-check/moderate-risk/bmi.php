<div class="question -no-num" data-moderate-risk-section="bmi">
    <div class="form-group">
        <div class="label">What is your height and weight?</div>
        <div class="label-line">
            <label for="bmi-height">Height (cm)</label>
            <label for="bmi-weight">Weight (kg)</label>
        </div>
        <div class="input-submit">
            <input
                id="bmi-height"
                type="number"
                name="height"
                min="0.1"
                max="5"
                maxlen="4"
                step="0.01"
                placeholder="cm"
                required
            />
            <input
                id="bmi-weight"
                type="number"
                name="weight"
                min="5"
                max="800"
                maxlen="3"
                placeholder="kg"
                required
            />
            <button type="button" class="button" aria-label="Next question">
                <span class="life life-chevron-right"></span>
            </button>
        </div>
    </div>
</div>
