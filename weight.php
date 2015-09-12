<?php include 'components/authentication.php' ?>
<?php include 'components/session-check.php' ?>
<?php include 'controllers/base/head.php' ?>
<?php include 'controllers/base/style.php' ?> 	
<?php include 'controllers/navigation/first-navigation.php' ?>   
<style>
.army-icon {
    display: inline-block;
    width: 45px;
    height: 45px;
    margin: 3px 3px 0px 0px;
    background: #CCC url("imagenes/troops/symbol-sprite.png") no-repeat scroll 0px 0px;
    opacity: 0.2;
    position: relative;
    border-radius: 6px;
    border: 1px solid #B6B6B6;
    box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}
.barbarian-icon { background-position: 0 -493px;}
.archer-icon { background-position: -45px -493px;}
.giant-icon { background-position: -90px -493px;}
.goblin-icon { background-position: -135px -493px;}
.wallbreaker-icon { background-position: -180px -493px;}
.balloon-icon { background-position: -225px -493px;}
.wizard-icon { background-position: -270px -493px;}
.healer-icon { background-position: -315px -493px;}

.dragon-icon { background-position: 0 -538px;}
.pekka-icon { background-position: -45px -538px;}
.minion-icon { background-position: -90px -538px;}
.hog-rider-icon { background-position: -135px -538px;}
.valkyrie-icon { background-position: -180px -538px;}
.golem-icon { background-position: -225px -538px;}
.witch-icon { background-position: -270px -538px;}
.lavahound-icon { background-position: -315px -538px;}

.barbarianking-icon { background-position: 0 -583px;}
.archerqueen-icon { background-position: -45px -583px;}
.lightningspell-icon { background-position: -90px -583px;}
.healingspell-icon { background-position: -135px -583px;}
.ragespell-icon { background-position: -180px -583px;}
.jumpspell-icon { background-position: -225px -583px;}
.freezespell-icon { background-position: -270px -583px;}
.santasspell-icon { background-position: -315px -583px;}


</style>  
     
     <div class="container" style="padding-top:50px;">
    <h1 class="text-center profile-text profile-name">Edit Rules</h1>
	   <div class="no-gutter row"> 
           <div class="col-md-12">
               <div class="panel panel-default" id="sidebar">
                   <div class="panel-body">     
                   
        <div class="army-list">
            <a href="http://www.warclans.com/wiki/barbarian-king" title="Barbarian King"><span class="army-icon active barbarianking-icon"><span>16</span></span></a>
            <a href="http://www.warclans.com/wiki/archer-queen" title="Archer Queen"><span class="army-icon active archerqueen-icon"><span>14</span></span></a>
            <a href="http://www.warclans.com/wiki/lightning-spell" title="Lightning Spell"><span class="army-icon active lightningspell-icon"><span>5</span></span></a>
            <a href="http://www.warclans.com/wiki/healing-spell" title="Healing Spell"><span class="army-icon active healingspell-icon top-lvl"><span>6</span></span></a>
            <a href="http://www.warclans.com/wiki/rage-spell" title="Rage Spell"><span class="army-icon active ragespell-icon top-lvl"><span>5</span></span></a>
            <a href="http://www.warclans.com/wiki/jump-spell" title="Jump Spell"><span class="army-icon active jumpspell-icon"><span>2</span></span></a>
            <a href="http://www.warclans.com/wiki/freeze-spell" title="Freeze Spell"><span class="army-icon freezespell-icon"></span></a>
        </div>
<div class="span12">
                                <div class="army-list">
                                    <a href="http://www.warclans.com/wiki/barbarian" title="Barbarian"><span class="army-icon active barbarian-icon"><span>5</span></span></a>
                                    <a href="http://www.warclans.com/wiki/archer" title="Archer"><span class="army-icon active archer-icon"><span>6</span></span></a>
                                    <a href="http://www.warclans.com/wiki/giant" title="Giant"><span class="army-icon active giant-icon"><span>6</span></span></a>
                                    <a href="http://www.warclans.com/wiki/goblin" title="Goblin"><span class="army-icon active goblin-icon"><span>5</span></span></a>
                                    <a href="http://www.warclans.com/wiki/wall-breaker" title="Wall Breaker"><span class="army-icon active wallbreaker-icon"><span>5</span></span></a>
                                    <a href="http://www.warclans.com/wiki/balloon" title="Balloon"><span class="army-icon active balloon-icon top-lvl"><span>6</span></span></a>
                                    <a href="http://www.warclans.com/wiki/wizard" title="Wizard"><span class="army-icon active wizard-icon"><span>5</span></span></a>
                                    <a href="http://www.warclans.com/wiki/healer" title="Healer"><span class="army-icon active healer-icon top-lvl"><span>4</span></span></a>
                                    <a href="http://www.warclans.com/wiki/dragon" title="Dragon"><span class="army-icon active dragon-icon"><span>3</span></span></a>
                                    <a href="http://www.warclans.com/wiki/pekka" title="P.E.K.K.A"><span class="army-icon active pekka-icon"><span>3</span></span></a>
                                    <a href="http://www.warclans.com/wiki/minion" title="Minion"><span class="army-icon active minion-icon"><span>4</span></span></a>
                                    <a href="http://www.warclans.com/wiki/hog-rider" title="Hog Rider"><span class="army-icon active hog-rider-icon top-lvl"><span>5</span></span></a>
                                    <a href="http://www.warclans.com/wiki/valkyrie" title="Valkyrie"><span class="army-icon active valkyrie-icon"><span>1</span></span></a>
                                    <a href="http://www.warclans.com/wiki/golem" title="Golem"><span class="army-icon active golem-icon"><span>4</span></span></a>
                                    <a href="http://www.warclans.com/wiki/witch" title="Witch"><span class="army-icon active witch-icon top-lvl"><span>2</span></span></a>
                                    <a href="http://www.warclans.com/wiki/lava-hound" title="Lava Hound"><span class="army-icon active lavahound-icon"><span>2</span></span></a>
                                </div>
                            </div>

                   </div>
               </div>
           </div>
        </div>
    </div>