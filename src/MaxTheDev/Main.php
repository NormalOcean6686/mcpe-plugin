<?php

namespace MaxTheDev;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\entity\Effect;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\math\Vector3;
use pocketmine\level\particle\{AngryVillagerParticle,BubbleParticle,CriticalParticle,DestroyBlockParticle,DustParticle,EnchantmentTableParticle,EnchantParticle,EntityFlameParticle,LargeExplodeParticle,FlameParticle,HappyVillagerParticle,HeartParticle,InkParticle,InstantEnchantParticle,ItemBreakParticle,LavaDripParticle,LavaParticle,MobSpellParticle,PortalParticle,RainSplashParticle,RedstoneParticle,SmokeParticle,SpellParticle,SplashParticle,SporeParticle,TerrainParticle,WaterDripParticle,WaterParticle,WhiteSmokeParticle};
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;
use jojoe77777\FormAPI;

class Main extends PluginBase implements Listener{
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->Info("Admin Service UI By Max TheDev Has Been Enabled!\nSubscribe To My Channel To Get More Intersting Plugins!");
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
		$player = $sender->getPlayer();
		switch($cmd->getName()){
			case "adsvui":
				if($sender->hasPermisson("admin.services.ui")){
					$this->adminForm($player);
					break;
			}
			return true;
		}
    }
	
	public function adminForm($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $form->createSimpleForm(function (Player $event, array $data){
			$result = $data[0];
			$player = $event->getPlayer();
			if($result === null){
			}
			switch($result){
				case 0:
				$this->sendttForm($player);
				break;
				case 1:
				$this->sendmsgForm($player);
				break;
				case 2:
				$this->giveitemForm($player);
				break;
				case 3:
				$this->kickForm($player);
				break;
				case 4:
				$this->banForm($player);
				break;
				case 5:
				$this->tellForm($player);
				break;
				case 6:
				$this->sendtttplayerForm($player);
				break;
				case 7:
				$this->sendmsgtplayerForm($player);
				break;
		}
		});
		$form->setTitle("§cAdmin §eServices");
		$form->setContent("§aCode By §bMax §eTheDev\n§o§6Choose One Command");
		$form->addButton("§oSend Title To The Server");
		$form->addButton("§oSend Messages To A Player");
		$form->addButton("§oGive A Item To Player");
		$form->addButton("§o§cKick A Player!");
		$form->addButton("§o§cBan A Player!");
		$form->addButton("§oTell A Player");
		$form->addButton("§oSend Title To A Player");
		$form->addButton("§oSend Messages To A Player");
		$form->sendToPlayer($player);
	}
	
	public function sendttForm($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $form->createCustomForm(function (Player $event, array $data){
			$result = $data[0];
			$player = $event->getPlayer();
			if($result === null){
			}
			switch($result){
				$this->getServer()->broadcastTitle($result);
				break;
			}
		}
		});
		$form->setTitle("§o§eSend Title To The Server");
		$form->addInput("§aType The Title Here");
		$form->sendToPlayer($player);
	}
	
	public function sendmsgForm($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $form->createCustomForm(function (Player $event, array $data){
			$result = $data[0];
			$player = $event->getPlayer();
			if($result === null){
			}
			switch($result){
				$this->getServer()->broadcastMessage($result);
				break;
			}
		}
		});
		$form->setTitle("§o§eSend Messages To The Server");
		$form->addInput("§aType The Title Here");
		$form->sendToPlayer($player);
	}
	
	public function giveitemForm($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $form->createCustomForm(function (Player $event, array $data){
			$result = $data[0];
			$result1 = $data[1];
			$result2 = $data[2];
			$result3 = $data[3];
			$player = $event->getPlayer();
			if($result === null){
			}
			switch($result){
				$playergive = $result;
				$item = Item::get($result1,$result2,$result3);
				$inv = $result->getInventory();
				$inv->addItem($item);
				break;
			}
		}
		});
		$form->setTitle("§o§eGive A Item To Player");
		$form->addLabel("§bType: <Player Name> <Item ID Or Name Of Item> <ID META> <AMMOUT>\n§rExample: OrtsOrtsGamer 2 0 64"); 
		$form->addInput("§aType Here!");
		$form->sendToPlayer($player);
	}

	public function kickForm($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $form->createCustomForm(function (Player $event, array $data){
			$result = $data[0];
			$player = $event->getPlayer();
			if($result === null){
			}
			switch($result){
				$this->getServer()->getCommandMap()->dispatch($player, "kick " . $result);
				break;
			}
		}
		});
		$form->setTitle("§o§cKick A Player!");
		$form->addInput("§aType Player Name");
		$form->sendToPlayer($player);
	}
	
	public function banForm($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $form->createCustomForm(function (Player $event, array $data){
			$result = $data[0];
			$player = $event->getPlayer();
			if($result === null){
			}
			switch($result){
				$this->getServer()->getCommandMap()->dispatch($player, "ban " . $result);
				break;
			}
		}
		});
		$form->setTitle("§o§cBan A Player!");
		$form->addInput("§aType Player Name");
		$form->sendToPlayer($player);
	}

	public function tellForm($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $form->createCustomForm(function (Player $event, array $data){
			$result = $data[0];
			$player = $event->getPlayer();
			if($result === null){
			}
			switch($result){
				$this->getServer()->getCommandMap()->dispatch($player, "tell " . $result);
				break;
			}
		}
		});
		$form->setTitle("§o§eTell A Player");
		$form->addInput("§aType Your Message Here");
		$form->sendToPlayer($player);
	}
	
	public function sendtttpForm($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $form->createCustomForm(function (Player $event, array $data){
			$result = $data[0];
			$result1 = $data[1];
			$player = $event->getPlayer();
			if($result === null){
			}
			switch($result){
				$result->addTitle($result1);
				break;
			}
		}
		});
		$form->setTitle("§o§eSend Title To A Player");
		$form->addLabel("§bType: <Player Name> <Title>\n§rExample: OrtsOrtsGamer Hi Dude!");
		$form->addInput("§aType Your Title Here");
		$form->sendToPlayer($player);
	}
	
	public function sendmsgtplayerForm($player);
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $form->createCustomForm(function (Player $event, array $data){
			$result = $data[0];
			$result1 = $data[1];
			$player = $event->getPlayer();
			if($result === null){
			}
			switch($result){
				$result->sendMessage($result1);
				break;
			}
		}
		});
		$form->setTitle("§o§eSend Message To A Player");
		$form->addLabel("§bType: <Player Name> <Message>\n§rExample: OrtsOrtsGamer Hi Dude!");
		$form->addInput("§aType Your Message Here");
		$form->sendToPlayer($player);
	}
}