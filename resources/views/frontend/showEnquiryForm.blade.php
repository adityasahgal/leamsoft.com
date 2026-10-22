<form class="qform" action="{{ url('/storeEnquiry') }}" method="POST">
    @csrf
    <div class="field">
        <label for="m-pname">Service</label>
        <input id="m-pname" type="text" readonly name="pname" value="{{ $data->product_name ?? $data->name ?? '' }}" required>
    </div>
    <div class="field">
        <label for="m-name">Name</label>
        <input id="m-name" type="text" name="name" autocomplete="name" required>
    </div>
    <div class="field">
        <label for="m-email">Email</label>
        <input id="m-email" type="email" name="email" autocomplete="email" required>
    </div>
    <div class="field">
        <label for="m-phone">Phone</label>
        <input id="m-phone" type="tel" name="phone" autocomplete="tel" required>
    </div>
    <div class="field">
        <label for="m-msg">Message</label>
        <textarea id="m-msg" name="message"></textarea>
    </div>
    <button type="submit" class="btn btn--primary">Send enquiry <svg class="icon arr"><use href="#i-arrow"/></svg></button>
</form>
