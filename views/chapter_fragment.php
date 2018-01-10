<div id="schoollayer2" style="background:#fff;width:980px;height:115px;"
class="mamase">
    <div class="kdhtyg">
        <div style="display:none;" id="examtypeselect" class="kstdg">
            <span id="examtypeselecttitle" class="xtitle" tag=2>
                请选择来源
            </span>
            <div class="liawtlet">
                <a id="examtype2" tag="2" href="javascript:void(0)">
                    学校题库
                </a>
            </div>
        </div>
        <div id="courseselect" class="kstdg" style="margin-left:0;">
            <span id="courseselecttit" class="xtitle" tag=0>
            	请选择课程
            </span>
            <div class="liawtlet" style="display:none;max-height:300px;overflow-y: auto;"></div>
        </div>
        <div id="middleselect" class="kstdg" style="margin-left:5px;">
            <span id="middleselecttitle" class="xtitle" tag=0>请选择版本</span>
            <div class="liawtlet" style="display:none;max-height:300px;overflow-y: auto;"></div>
        </div>
        <div id="mysecondselect" class="kstdg" style="margin-left:5px;display:none;">
        	<span id="mysecondselecttitle" class="xtitle"  tag=0>请选择知识点</span>
        	<div class="liawtlet" style="display:block;max-height:300px;overflow-y: scroll;"></div>
        </div>
        <div id="mythirdselect" class="kstdg" style="margin-left:5px;width:380px;display:none;">
            <span id="mythirdselecttitle" class="xtitle" tag=0>请选择知识点</span>
			<input type="hidden" class="chapterpath" />
            <div id="thirdselectpanel" style="position:absolute;top:24px;left:-1px;border: solid 1px #d9d9d9;display:none;">
            </div>
        </div>
    </div>
    <h2 class="ferygur">
        <span>
            题型过滤
        </span>
    </h2>
    <div class="kstytwr" id="kstytwrt" style="margin:15px 0 15px 0px;">
        <ul>
            <li class="kedtg">
                <input id="myallquet" type="radio" checked="checked" value="0" name="myquetype">
                <label for="myallquet">
                    全部
                </label>
            </li>
           <!--  <li class="kedtg">
                <input id="myxquet" type="radio" value="X" name="myquetype">
                <label for="myxquet">
                    答题卡
                </label>
            </li> -->
            <li class="kedtg">
                <input id="myaquet" type="radio" value="A" name="myquetype">
                <label for="myaquet">
                    单选题
                </label>
            </li>
            <li class="kedtg">
                <input id="mybquet" type="radio" value="B" name="myquetype">
                <label for="mybquet">
                    多选题
                </label>
            </li>
            <li class="kedtg">
                <input id="mydquet" type="radio" value="D" name="myquetype">
                <label for="mydquet">
                    判断题
                </label>
            </li>
            <li class="kedtg">
                <input id="mycquet" type="radio" value="C" name="myquetype">
                <label for="mycquet">
                    填空题
                </label>
            </li>
            <li class="kedtg">
                <input id="myequet" type="radio" value="E" name="myquetype">
                <label for="myequet">
                    文字题
                </label>
            </li>
            <li class="kedtg">
                <input id="myhquet" type="radio" value="H" name="myquetype">
                <label for="myhquet">
                    主观题
                </label>
            </li>
        </ul>
    </div>
</div>