<?php $this->load->view('header') ?>

<div id="content" class="group">
    <div id="main">
        <ul class="tabs">
            <li class="selected"><a href="#" class="selected"><?= $this->lang->line('groupall_create_group'); ?></a></li>
            <a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('group')?>"><?= $this->lang->line('groupcreate_back'); ?></a>
        </ul>
        <div class="session-form alt" id="profile">
            <form action="<?=site_url('group/save')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">
                <div class="form-field">
                    <fieldset>
                        <label for="title"><?= $this->lang->line('groupcreate_name'); ?></label>
                        <input type="text" class="signin_input txt" id="title" name="name" placeholder="" value="">
                        <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('groupcreate_error'); ?></span>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="desc"><?= $this->lang->line('groupcreate_description'); ?></label>
                        <textarea name="desc" id="desc" class="signin_input txt"  style="height: 270px; "  placeholder=""/></textarea>
                        <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('groupcreate_error'); ?></span>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="type"><?= $this->lang->line('groupcreate_type'); ?></label>
                        <select name="type" class="support-select" id="type">
                            <?php foreach($group_type_list as $_group_type): ?>
                            <option value="<?php echo $_group_type['id']; ?>"><?= ($lang == 2)?$_group_type['name_cn']:$_group_type['type_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="url"><?= $this->lang->line('groupcreate_icon'); ?></label>
                        <div style="padding-bottom:5px">
                            <input type="text" readonly style="width:220px;display:auto" value="" name="upfile" id="upfile" class="txt create_input">
                            <input type="button" class="form-btn" value="<?= $this->lang->line('groupcreate_browse'); ?>" onclick="url.click()">
                            <input type="file" id="url" name="url" style="display:none" onchange="upfile.value=this.value" value="">
                            <span id="iconError" class="formErrorContent drop-shadow"><?= $this->lang->line('groupcreate_error'); ?></span></div>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="private"><?= $this->lang->line('groupcreate_private'); ?></label>
                        <input type="checkbox" name="private" id="private" style="display:inline;margin-top:12px;">
                        <br />
                        <br />
                    </fieldset>
                </div>
                <div class="form-btns">
                    <input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('groupcreate_create'); ?>" onclick="checkgroup()">
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('footer') ?>
