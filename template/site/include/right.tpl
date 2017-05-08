 <div class="col-md-4">
			{foreach $right as $key=>$val}
              <div class="list-group" style="border:1px solid rgb(66,160,121);">
                <a href="" class=" special-intem list-group-item disabled" style="background:rgb(66, 160, 121);color:white;">
                  {$val['title']}
                </a>
				{foreach $val['list'] as $list}
				<a href="/news/index?type={$list['ni_if_img_text']}&no={$list['ni_no']}" style="font-size:12px;padding-left:2rem;" class="list-group-item ">
                  {$list['ni_title']|htmlspecialchars}
                </a>
				{/foreach}
              </div>
			  {/foreach}
            </div>