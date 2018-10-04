<?php
/**
 * IsBizMail tells you whether a given email address
 * is free e.g. gmail.com, yahoo.es, yandex.ru etc or not.
 * The list of emails used by IsBizMail is taken from here:
 * http://svn.apache.org/repos/asf/spamassassin/trunk/rules/20_freemail_domains.cf
 * All credits for the list itself go to SpamAssasin authors and contributors
 *
 * @category PHPUnit
 * @package  IsBizMail
 * @author   Zhmayev Yaroslav <salaros@salaros.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/salaros/free-mailchecker
 */

namespace Salaros\Email;

/**
 * Tells you whether a given email address is free  or not
 */
class IsBizMail
{
    private static $freeMailDomains;
    private static $freeMailPatterns;

    /**
     * Tells you if a given email is valid in terms of structure
     * and if it does not belong to one of known free mail box providers
     *
     * @param string $email Email address
     *
     * @return bool
     */
    public function isValid($email)
    {
        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return (isset($this) && $this instanceof self)
            ? !$this->isFreeMailAddress($email)
            : !self::isFreeMailAddress($email);
    }

    /**
     * Returns true if a given email belong to one of known free mail box providers
     *
     * @param string $email Email address
     *
     * @return bool
     */
    public function isFreeMailAddress($email)
    {
        $parts = explode("@", $email);
        $emailDomain = strtolower(end($parts));

        if (empty($emailDomain)) {
            throw new \InvalidArgumentException("You have supplied an invalid email address");
        }

        if (false !== stripos($emailDomain, '*')) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Domain part of the the following email contains a wildcard, which is not allowed: '%s'",
                    $email
                )
            );
        }

        // Check if the giveb domain is among known free providers
        if (in_array($emailDomain, self::getFreeDomains())) {
            return true;
        }

        // Check if patterns match the given domain
        foreach (self::getFreeDomainPatterns() as $pattern) {
            if (fnmatch($pattern, $emailDomain)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets the list of all known free mail box providers
     * @codeCoverageIgnore
     *
     * @return array
     */
    public function getFreeDomains()
    {
        if (is_null(self::$freeMailDomains)) {
            self::init();
        }

        return self::$freeMailDomains;
    }

    /**
     * Gets the list of wildcards matching some free mail box providers
     * @codeCoverageIgnore
     *
     * @return array
     */
    public function getFreeDomainPatterns()
    {
        if (is_null(self::$freeMailPatterns)) {
            self::init();
        }

        return self::$freeMailPatterns;
    }

    /**
     * Initializes the array of known free email domains
     * contains both full domains and widlcards
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @codeCoverageIgnore
     *
     * @return void
     */
    public static function init()
    {
        // phpcs:disable Generic.Files.LineLength
        self::$freeMailPatterns = array(
            // free email patterns start
            "aol.*", "aol.co*.*", "*.att.ne.jp", "excite.*", "excite.co*.*", "fastmail.*",
            "fastmail.co*.*", "freemail.*", "freemail.*.*", "gmx.*", "hotmail.*", "hotmail.co*.*",
            "live.*", "lycos.*", "lycos.co*.*", "mail2*.com", "ms*.hinet.net", "outlook.*",
            "strompost.*", "terra.*", "terra.co*.*", "tiscali.*", "tiscali.co*.*", "vodafone.*",
            "xemail.*", "yahoo.*", "yahoo.co*.*", "yandex.*", "runbox.*", "*.onmicrosoft.com",
            // free email patterns end
        );

        self::$freeMailDomains = array(
            // free email providers start
            "020.co.uk", "123.com", "123box.net", "123india.com", "123mail.cl", "123mail.org",
            "123qwe.co.uk", "138mail.com", "141.ro", "150mail.com", "150ml.com", "16mail.com",
            "1963chevrolet.com", "1963pontiac.com", "1netdrive.com", "1st-website.com", "1stpd.net", "2-mail.com",
            "20after4.com", "21cn.com", "24h.co.jp", "24horas.com", "271soundview.com", "2die4.com",
            "2mydns.com", "2net.us", "3000.it", "3ammagazine.com", "3email.com", "3xl.net",
            "444.net", "4email.com", "4email.net", "4newyork.com", "50mail.com", "55mail.cc",
            "5fm.za.com", "6210.hu", "6sens.com", "702mail.co.za", "7110.hu", "8848.net",
            "8m.com", "8m.net", "8x.com.br", "8u8.com", "8u8.hk", "8u8.tw",
            "9.cn", "a-topmail.at", "about.com", "abv.bg", "acceso.or.cr", "access4less.net",
            "accessgcc.com", "acmemail.net", "adiga.com", "adinet.com.uy", "adres.nl", "advalvas.be",
            "aeiou.pt", "aeneasmail.com", "afrik.com", "afropoets.com", "aggies.com", "ahaa.dk",
            "aichi.com", "aim.com", "airpost.net", "aiutamici.com", "aklan.com", "aknet.kg",
            "alabama.usa.com", "alaska.usa.com", "alavatotal.com", "albafind.com", "albawaba.com", "alburaq.net",
            "aldeax.com", "aldeax.com.ar", "alex4all.com", "aliyun.com", "alexandria.cc", "algeria.com",
            "alice.it", "alinto.com", "allmail.net", "alskens.dk", "altavista.se", "altbox.org",
            "alternativagratis.com", "alum.com", "alunos.unipar.br", "alvilag.hu", "amenworld.com", "america.hm",
            "americamail.com", "amnetsal.com", "amorous.com", "ananzi.co.za", "anet.ne.jp", "anfmail.com",
            "angelfire.com", "animail.net", "aniverse.com", "anjungcafe.com", "another.com", "antedoonsub.com",
            "antwerpen.com", "anunciador.net", "anytimenow.com", "aon.at", "apexmail.com", "apollo.lv",
            "approvers.net", "aprava.com", "apropo.ro", "arcor.de", "argentina.com", "arizona.usa.com",
            "arkansas.usa.com", "armmail.com", "army.com", "arnet.com.ar", "aroma.com", "arrl.net",
            "aruba.it", "asheville.com", "asia-links.com", "asiamail.com", "assala.com", "assamesemail.com",
            "asurfer.com", "atl.lv", "atlas.cz", "atlas.sk", "atozasia.com", "atreillou.com",
            "att.net", "au.ru", "aubenin.com", "aus-city.com", "aussiemail.com.au", "avasmail.com.mv",
            "axarnet.com", "ayna.com", "azet.sk", "babbalu.com", "badgers.com", "bakpaka.com",
            "bakpaka.net", "balochistan.org", "baluch.com", "bama-fan.com", "bancora.net", "bankersmail.com",
            "barlick.net", "beeebank.com", "beehive.org", "been-there.com", "beirut.com", "belizehome.com",
            "belizemail.net", "belizeweb.com", "bellsouth.net", "berlin.de", "bestmail.us", "bflomail.com",
            "bgnmail.com", "bharatmail.com", "big-orange.com", "bigboss.cz", "bigfoot.com", "bigger.com",
            "bigmailbox.com", "bigmir.net", "bigstring.com", "bip.net", "bigpond.com", "bitwiser.com",
            "biz.by", "bizhosting.com", "black-sea.ro", "blackburnmail.com", "blackglobalnetwork.net", "blink182.net",
            "blue.devils.com", "bluebottle.com", "bluemail.ch", "blumail.org", "blvds.com", "bol.com.br",
            "bolando.com", "bollywood2000.com", "bollywoodz.com", "bolt.com", "bombka.dyn.pl", "bonbon.net",
            "boom.com", "bootmail.com", "bostonoffice.com", "box.az", "boxbg.com", "boxemail.com",
            "brain.com.pk", "brasilia.net", "bravanese.com", "brazilmail.com.br", "breathe.com", "brestonline.com",
            "brfree.com.br", "brujula.net", "btcc.org", "buffaloes.com", "bulgaria.com", "bulldogs.com",
            "bumerang.ro", "burntmail.com", "butch-femme.net", "buzy.com", "buzzjakkerz.com", "c-box.cz",
            "c3.hu", "c4.com", "cadinfo.net", "calcfacil.com.br", "calcware.org", "california.usa.com",
            "callnetuk.com", "camaroclubsweden.com", "canada-11.com", "canada.com", "canal21.com", "canoemail.com",
            "caramail.com", "cardblvd.com", "care-mail.com", "care2.com", "caress.com", "carioca.net",
            "cashette.com", "casino.com", "casinomail.com", "cataloniamail.com", "catalunyamail.com", "cataz.com",
            "catcha.com", "catholic.org", "caths.co.uk", "caxess.net", "cbrmail.com", "cc.lv",
            "cemelli.com", "centoper.it", "centralpets.com", "centrum.cz", "centrum.sk", "centurylink.net",
            "cercaziende.it", "cgac.es", "chaiyo.com", "chaiyomail.com", "chance2mail.com", "channelonetv.com",
            "charter.net", "chattown.com", "checkitmail.at", "chelny.com", "cheshiremail.com", "chil-e.com",
            "chillimail.com", "china.com", "christianmail.org", "ciaoweb.it", "cine.com", "ciphercom.net",
            "circlemail.com", "cititrustbank1.cjb.net", "citromail.hu", "citynetusa.com", "ciudad.com.ar", "claramail.com",
            "classicmail.co.za", "cliffhanger.com", "clix.pt", "close2you.net", "cluemail.com", "clujnapoca.ro",
            "collegeclub.com", "colombia.com", "colorado.usa.com", "comcast.net", "comfortable.com", "compaqnet.fr",
            "compuserve.com", "computer.net", "computermail.net", "computhouse.com", "conevyt.org.mx", "connect4free.net",
            "connecticut.usa.com", "coolgoose.com", "coolkiwi.com", "coollist.com", "coxinet.net", "coolmail.com",
            "coolmail.net", "coolsend.com", "cooltoad.com", "cooperation.net", "copacabana.com", "copticmail.com",
            "corporateattorneys.com", "corporation.net", "correios.net.br", "correomagico.com", "cosmo.com", "cosmosurf.net",
            "cougars.com", "count.com", "countrybass.com", "couple.com", "criticalpath.net", "critterpost.com",
            "crosspaths.net", "crosswinds.net", "cryingmail.com", "cs.com", "csucsposta.hu", "cumbriamail.com",
            "curio-city.com", "custmail.com", "cwazy.co.uk", "cwazy.net", "cww.de", "cyberaccess.com.pk",
            "cybergirls.dk", "cyberguys.dk", "cybernet.it", "cymail.net", "dabsol.net", "dada.net",
            "dadanet.it", "dailypioneer.com", "damuc.org.br", "dansegulvet.com", "darkhorsefan.net", "data54.com",
            "davegracey.com", "dayzers.com", "daum.net", "dbmail.com", "dcemail.com", "dcsi.net",
            "deacons.com", "deadlymob.org", "deal-maker.com", "dearriba.com", "degoo.com", "delajaonline.org",
            "delaware.usa.com", "delfi.lv", "delhimail.com", "demon.deacons.com", "desertonline.com", "desidrivers.com",
            "deskpilot.com", "despammed.com", "detik.com", "devils.com", "dexara.net", "dhmail.net",
            "di-ve.com", "didamail.com", "digitaltrue.com", "direccion.com", "director-general.com", "diri.com",
            "discardmail.com", "discoverymail.net", "disinfo.net", "djmillenium.com", "dmailman.com", "dnsmadeeasy.com",
            "do.net.ar", "dodgeit.com", "dogmail.co.uk", "doityourself.com", "domaindiscover.com", "domainmanager.com",
            "doneasy.com", "dontexist.org", "dores.com", "dostmail.com", "dot5hosting.com", "dotcom.fr",
            "dotnow.com", "dott.it", "doubt.com", "dplanet.ch", "dragoncon.net", "dragonfans.com",
            "dropzone.com", "dserver.org", "dubaiwebcity.com", "dublin.ie", "dustdevil.com", "dynamitemail.com",
            "dyndns.org", "e-apollo.lv", "e-hkma.com", "e-mail.cz", "e-mail.ph", "e-mailanywhere.com",
            "e-milio.com", "e-tapaal.com", "e-webtec.com", "earthalliance.com", "earthling.net", "eastmail.com",
            "eastrolog.com", "easy-pages.com", "easy.com", "easyinfomail.co.za", "easypeasy.com", "echina.com",
            "ecn.org", "ecplaza.net", "eircom.net", "edsamail.com.ph", "educacao.te.pt", "edumail.co.za",
            "eeism.com", "ego.co.th", "ekolay.net", "elforotv.com.ar", "elitemail.org", "elsitio.com",
            "eltimon.com", "elvis.com", "email.com.br", "email.cz", "email.bg", "email.it",
            "email.lu", "email.lviv.ua", "email.nu", "email.ro", "email.si", "email2me.com",
            "emailacc.com", "emailaccount.com", "emailaddresses.com", "emailchoice.com", "emailcorner.net", "emailn.de",
            "emailengine.net", "emailengine.org", "emailgaul.com", "emailgroups.net", "emailhut.net", "emailpinoy.com",
            "emailplanet.com", "emailplus.org", "emailuser.net", "ematic.com", "embarqmail.com", "embroideryforums.com",
            "eml.cc", "emoka.ro", "emptymail.com", "enel.net", "enelpunto.net", "england.com",
            "enterate.com.ar", "entryweb.it", "entusiastisk.com", "enusmail.com", "epatra.com", "epix.net",
            "epomail.com", "epost.de", "eprompter.com", "eqqu.com", "eramail.co.za", "eresmas.com",
            "eriga.lv", "ertelecom.ru", "esde-s.org", "esfera.cl", "estadao.com.br", "etllao.com",
            "euromail.net", "euroseek.com", "euskalmail.com", "evafan.com", "everyday.com.kh", "everymail.net",
            "everyone.net", "execs2k.com", "executivemail.co.za", "expn.com", "ezilon.com", "ezrs.com",
            "f-m.fm", "facilmail.com", "fadrasha.net", "fadrasha.org", "faithhighway.com", "faithmail.com",
            "familymailbox.com", "familyroll.com", "familysafeweb.net", "fan.com", "fan.net", "faroweb.com",
            "fast-email.com", "fast-mail.org", "fastem.com", "fastemail.us", "fastemailer.com", "fastermail.com",
            "fastest.cc", "fastimap.com", "fastmailbox.net", "fastmessaging.com", "fastwebmail.it", "fawz.net",
            "fea.st", "federalcontractors.com", "fedxmail.com", "feelings.com", "female.ru", "fepg.net",
            "ffanet.com", "fiberia.com", "filipinolinks.com", "financesource.com", "findmail.com", "fiscal.net",
            "flashmail.com", "flipcode.com", "florida.usa.com", "floridagators.com", "fmail.co.uk", "fmailbox.com",
            "fmgirl.com", "fmguy.com", "fnmail.com", "footballer.com", "foxmail.com", "forfree.at",
            "forsythmissouri.org", "fortuncity.com", "forum.dk", "free.com.pe", "free.fr", "free.net.nz",
            "freeaccess.nl", "freegates.be", "freeghana.com", "freehosting.nl", "freei.co.th", "freeler.nl",
            "freemail.globalsite.com.br", "freemuslim.net", "freenet.de", "freenet.kg", "freeola.net", "freepgs.com",
            "freesbee.fr", "freeserve.co.uk", "freeservers.com", "freestart.hu", "freesurf.ch", "freesurf.fr",
            "freesurf.nl", "freeuk.com", "freeuk.net", "freeweb.it", "freewebemail.com", "freeyellow.com",
            "frisurf.no", "frontiernet.net", "fsmail.net", "fsnet.co.uk", "ftml.net", "fuelie.org",
            "fun-greetings-jokes.com", "fun.21cn.com", "fusemail.com", "fut.es", "gala.net", "galmail.co.za",
            "gamebox.net", "gamecocks.com", "gawab.com", "gay.com", "gaymailbox.com", "gaza.net",
            "gazeta.pl", "gci.net", "gdi.net", "geeklife.com", "gemari.or.id", "genxemail.com",
            "geopia.com", "georgia.usa.com", "getmail.no", "ggaweb.ch", "giga4u.de", "gjk.dk",
            "glay.org", "glendale.net", "globalfree.it", "globomail.com", "globalpinoy.com", "globalsite.com.br",
            "globalum.com", "globetrotter.net", "gmail.com", "go-bama.com", "go-cavs.com", "go-chargers.com",
            "go-dawgs.com", "go-gators.com", "go-hogs.com", "go-irish.com", "go-spartans.com", "go-tigers.com",
            "go.aggies.com", "go.air-force.com", "go.badgers.com", "go.big-orange.com", "go.blue.devils.com", "go.buffaloes.com",
            "go.bulldogs.com", "go.com", "go.cougars.com", "go.dores.com", "go.gamecocks.com", "go.huskies.com",
            "go.longhorns.com", "go.mustangs.com", "go.rebels.com", "go.ro", "go.ru", "go.terrapins.com",
            "go.wildcats.com", "go.wolverines.com", "go.yellow-jackets.com", "go2net.com", "go4.it", "gofree.co.uk",
            "golfemail.com", "goliadtexas.com", "gomail.com.ua", "gonowmail.com", "gonuts4free.com", "googlemail.com",
            "goplay.com", "gorontalo.net", "gotmail.com", "gotomy.com", "govzone.com", "grad.com",
            "graffiti.net", "gratisweb.com", "gtechnics.com", "guate.net", "guessmail.com", "gwalla.com",
            "h-mail.us", "haberx.com", "hailmail.net", "halejob.com", "hamptonroads.com", "handbag.com",
            "hanmail.net", "happemail.com", "happycounsel.com", "hawaii.com", "hawaii.usa.com", "hayahaya.tg",
            "hedgeai.com", "heesun.net", "heremail.com", "hetnet.nl", "highveldmail.co.za", "hildebrands.de",
            "hingis.org", "hispavista.com", "hitmanrecords.com", "hockeyghiaccio.com", "hockeymail.com", "holapuravida.com",
            "home.no.net", "home.ro", "home.se", "homelocator.com", "homemail.co.za", "homenetmail.com",
            "homestead.com", "homosexual.net", "hongkong.com", "hong-kong-1.com", "hopthu.com", "hosanna.net",
            "hot.ee", "hotbot.com", "hotbox.ru", "hotcoolmail.com", "hotdak.com", "hotfire.net",
            "hotinbox.com", "hotpop.com", "hotvoice.com", "hour.com", "howling.com", "huhmail.com",
            "humour.com", "hurra.de", "hush.ai", "hush.com", "hushmail.com", "huskies.com",
            "hutchcity.com", "i-france.com", "i-p.com", "i12.com", "i2828.com", "ibatam.com",
            "ibest.com.br", "ibizdns.com", "icafe.com", "ice.is", "icestorm.com", "icloud.com",
            "icq.com", "icqmail.com", "icrazy.com", "id.ru", "idaho.usa.com", "idirect.com",
            "idncafe.com", "ieg.com.br", "iespalomeras.net", "iespana.es", "ifrance.com", "ig.com.br",
            "ignazio.it", "illinois.usa.com", "ilse.net", "ilse.nl", "imail.ru", "imailbox.com",
            "imap-mail.com", "imap.cc", "imapmail.org", "imel.org", "in-box.net", "inbox.com",
            "inbox.ge", "inbox.lv", "inbox.net", "inbox.ru", "in.com", "incamail.com",
            "indexa.fr", "india.com", "indiamail.com", "indiana.usa.com", "indiatimes.com", "induquimica.org",
            "inet.com.ua", "infinito.it", "infoapex.com", "infohq.com", "infomail.es", "infomart.or.jp",
            "infosat.net", "infovia.com.ar", "inicia.es", "inmail.sk", "inmail24.com", "inoutbox.com",
            "intelnet.net.gt", "intelnett.com", "interblod.com", "interfree.it", "interia.pl", "interlap.com.ar",
            "intermail.hu", "internet-e-mail.com", "internet-mail.org", "internet.lu", "internetegypt.com", "internetemails.net",
            "internetmailing.net", "inwind.it", "iobox.com", "iobox.fi", "iol.it", "iol.pt",
            "iowa.usa.com", "ip3.com", "ipermitmail.com", "iqemail.com", "iquebec.com", "iran.com",
            "irangate.net", "iscool.net", "islandmama.com", "ismart.net", "isonews2.com", "isonfire.com",
            "isp9.net", "ispey.com", "itelgua.com", "itloox.com", "itmom.com", "ivenus.com",
            "iwan-fals.com", "iwon.com", "ixp.net", "japan.com", "jaydemail.com", "jedrzejow.pl",
            "jetemail.net", "jingjo.net", "jippii.fi", "jmail.co.za", "jojomail.com", "jovem.te.pt",
            "joymail.com", "jubii.dk", "jubiipost.dk", "jumpy.it", "juno.com", "justemail.net",
            "justmailz.com", "k.ro", "kaazoo.com", "kabissa.org", "kaixo.com", "kalluritimes.com",
            "kalpoint.com", "kansas.usa.com", "katamail.com", "kataweb.it", "kayafmmail.co.za", "keko.com.ar",
            "kentucky.usa.com", "keptprivate.com", "kimo.com", "kiwitown.com", "klik.it", "klikni.cz",
            "kmtn.ru", "koko.com", "kolozsvar.ro", "kombud.com", "koreanmail.com", "kotaksuratku.info",
            "krunis.com", "kukamail.com", "kuronowish.com", "kyokodate.com", "kyokofukada.net", "ladymail.cz",
            "lagoon.nc", "lahaonline.com", "lamalla.net", "lancsmail.com", "land.ru", "laposte.net",
            "latinmail.com", "lawyer.com", "lawyersmail.com", "lawyerzone.com", "lebanonatlas.com", "leehom.net",
            "leonardo.it", "leonlai.net", "letsjam.com", "letterbox.org", "letterboxes.org", "levele.com",
            "lexpress.net", "libero.it", "liberomail.com", "libertysurf.net", "libre.net", "lightwines.org",
            "linkmaster.com", "linuxfreemail.com", "lionsfan.com.au", "livedoor.com", "llandudno.com", "llangollen.com",
            "lmxmail.sk", "loggain.net", "loggain.nu", "lolnetwork.net", "london.com", "longhorns.com",
            "look.com", "looksmart.co.uk", "looksmart.com", "looksmart.com.au", "loteria.net", "lotonazo.com",
            "louisiana.usa.com", "louiskoo.com", "loveable.com", "lovemail.com", "lovingjesus.com", "lpemail.com",
            "luckymail.com", "luso.pt", "lusoweb.pt", "luukku.com", "lycosmail.com", "mac.com",
            "machinecandy.com", "macmail.com", "mad.scientist.com", "madcrazy.com", "madonno.com", "madrid.com",
            "mag2.com", "magicmail.co.za", "magik-net.com", "mail-atlas.net", "mail-awu.de", "mail-box.cz",
            "mail.by", "mail-center.com", "mail-central.com", "mail-jp.org", "mail-online.dk", "mail-page.com",
            "mail-x-change.com", "mail.austria.com", "mail.az", "mail.de", "mail.be", "mail.bg",
            "mail.bulgaria.com", "mail.co.za", "mail.dk", "mail.ee", "mail.goo.ne.jp", "mail.gr",
            "mail.lawguru.com", "mail.md", "mail.mn", "mail.org", "mail.pf", "mail.pt",
            "mail.ru", "mail.yahoo.co.jp", "mail15.com", "mail3000.com", "mail333.com", "mail8.com",
            "mailandftp.com", "mailandnews.com", "mailas.com", "mailasia.com", "mailbg.com", "mailblocks.com",
            "mailbolt.com", "mailbox.as", "mailbox.co.za", "mailbox.gr", "mailbox.hu", "mailbox.sk",
            "mailc.net", "mailcan.com", "mailcircuit.com", "mailclub.fr", "mailclub.net", "maildozy.com",
            "mailfly.com", "mailforce.net", "mailftp.com", "mailglobal.net", "mailhaven.com", "mailinator.com",
            "mailingaddress.org", "mailingweb.com", "mailisent.com", "mailite.com", "mailme.dk", "mailmight.com",
            "mailmij.nl", "mailnew.com", "mailops.com", "mailpanda.com", "mailpersonal.com", "mailroom.com",
            "mailru.com", "mails.de", "mailsent.net", "mailserver.dk", "mailservice.ms", "mailsnare.net",
            "mailsurf.com", "mailup.net", "mailvault.com", "mailworks.org", "maine.usa.com", "majorana.martina-franca.ta.it",
            "maktoob.com", "malayalamtelevision.net", "malayalapathram.com", "male.ru", "manager.de", "manlymail.net",
            "mantrafreenet.com", "mantramail.com", "mantraonline.com", "marihuana.ro", "marijuana.nl", "marketweighton.com",
            "maryland.usa.com", "masrawy.com", "massachusetts.usa.com", "mauimail.com", "mbox.com.au", "mcrmail.com",
            "me.by", "me.com", "medicinatv.com", "meetingmall.com", "megamail.pt", "menara.ma",
            "merseymail.com", "mesra.net", "messagez.com", "metacrawler.com", "mexico.com", "miaoweb.net",
            "michigan.usa.com", "micro2media.com", "miesto.sk", "mighty.co.za", "milacamn.net", "milmail.com",
            "mindless.com", "mindviz.com", "minnesota.usa.com", "mississippi.usa.com", "missouri.usa.com", "mixmail.com",
            "ml1.net", "ml2clan.com", "mlanime.com", "mm.st", "mmail.com", "mobimail.mn",
            "mobsters.com", "mobstop.com", "modemnet.net", "modomail.com", "moldova.com", "moldovacc.com",
            "monarchy.com", "montana.usa.com", "montevideo.com.uy", "moomia.com", "moose-mail.com", "mosaicfx.com",
            "motormania.com", "movemail.com", "mr.outblaze.com", "mrspender.com", "mscold.com", "msn.com",
            "msn.co.uk", "msnzone.cn", "mundo-r.com", "muslimsonline.com", "mustangs.com", "mxs.de",
            "myblue.cc", "mycabin.com", "mycity.com", "mycommail.com", "mycool.com", "mydomain.com",
            "myeweb.com", "myfastmail.com", "myfunnymail.com", "mykolab.com", "mygamingconsoles.com", "myiris.com",
            "myjazzmail.com", "mymacmail.com", "mymail.dk", "mymail.ph.inter.net", "mymail.ro", "mynet.com",
            "mynet.com.tr", "myotw.net", "myopera.com", "myownemail.com", "mypersonalemail.com", "myplace.com",
            "myrealbox.com", "myspace.com", "myt.mu", "myway.com", "mzgchaos.de", "n2.com",
            "n2business.com", "n2mail.com", "n2software.com", "nabble.com", "name.com", "nameplanet.com",
            "nanamail.co.il", "nanaseaikawa.com", "nandomail.com", "naseej.com", "nastything.com", "national-champs.com",
            "nativeweb.net", "narod.ru", "nate.com", "naveganas.com", "naver.com", "nebraska.usa.com",
            "nemra1.com", "nenter.com", "nerdshack.com", "nervhq.org", "net.hr", "net4b.pt",
            "net4jesus.com", "net4you.at", "netbounce.com", "netcabo.pt", "netcape.net", "netcourrier.com",
            "netexecutive.com", "netfirms.com", "netkushi.com", "netmongol.com", "netpiper.com", "netposta.net",
            "netscape.com", "netscape.net", "netscapeonline.co.uk", "netsquare.com", "nettaxi.com", "netti.fi",
            "networld.com", "netzero.com", "netzero.net", "neustreet.com", "nevada.usa.com", "newhampshire.usa.com",
            "newjersey.usa.com", "newmail.com", "newmail.net", "newmail.ok.com", "newmail.ru", "newmexico.usa.com",
            "newspaperemail.com", "newyork.com", "newyork.usa.com", "newyorkcity.com", "nfmail.com", "nicegal.com",
            "nightimeuk.com", "nightly.com", "nightmail.com", "nightmail.ru", "noavar.com", "noemail.com",
            "nonomail.com", "nokiamail.com", "noolhar.com", "northcarolina.usa.com", "northdakota.usa.com", "nospammail.net",
            "nowzer.com", "ny.com", "nyc.com", "nz11.com", "nzoomail.com", "o2.pl",
            "oceanfree.net", "ocsnet.net", "oddpost.com", "odeon.pl", "odmail.com", "offshorewebmail.com",
            "ofir.dk", "ohio.usa.com", "oicexchange.com", "ok.ru", "oklahoma.usa.com", "ole.com",
            "oleco.net", "olympist.net", "omaninfo.com", "onatoo.com", "ondikoi.com", "onebox.com",
            "onenet.com.ar", "onet.pl", "ongc.net", "oninet.pt", "online.ie", "online.ru",
            "onlinewiz.com", "onobox.com", "open.by", "openbg.com", "openforyou.com", "opentransfer.com",
            "operamail.com", "oplusnet.com", "orange.fr", "orangehome.co.uk", "orange.es", "orange.jo",
            "orange.pl", "orbitel.bg", "orcon.net.nz", "oregon.usa.com", "oreka.com", "organizer.net",
            "orgio.net", "orthodox.com", "osite.com.br", "oso.com", "ourbrisbane.com", "ournet.md",
            "ourprofile.net", "ourwest.com", "outgun.com", "ownmail.net", "oxfoot.com", "ozu.es",
            "pacer.com", "paginasamarillas.com", "pakistanmail.com", "pandawa.com", "pando.com", "pandora.be",
            "paris.com", "parsimail.com", "parspage.com", "patmail.com", "pattayacitythailand.com", "pc4me.us",
            "pcpostal.com", "penguinmaster.com", "pennsylvania.usa.com", "peoplepc.com", "peopleweb.com", "personal.ro",
            "personales.com", "peru.com", "petml.com", "phreaker.net", "pigeonportal.com", "pilu.com",
            "pimagop.com", "pinoymail.com", "pipni.cz", "pisem.net", "planet-school.de", "planetaccess.com",
            "planetout.com", "plasa.com", "playersodds.com", "playful.com", "pluno.com", "plusmail.com.br",
            "pmail.net", "pnetmail.co.za", "pobox.ru", "pobox.sk", "pochtamt.ru", "pochta.ru",
            "poczta.fm", "poetic.com", "pogowave.com", "polbox.com", "pop3.ru", "pop.co.th",
            "popmail.com", "poppymail.com", "popsmail.com", "popstar.com", "portafree.com", "portaldosalunos.com",
            "portugalmail.com", "portugalmail.pt", "post.cz", "post.expart.ne.jp", "post.pl", "post.sk",
            "posta.ge", "postaccesslite.com", "postiloota.net", "postinbox.com", "postino.ch", "postino.it",
            "postmaster.co.uk", "postpro.net", "praize.com", "press.co.jp", "primposta.com", "printesamargareta.ro",
            "private.21cn.com", "probemail.com", "profesional.com", "profession.freemail.com.br", "proinbox.com", "promessage.com",
            "prontomail.com", "protonmail.com", "protonmail.ch", "provincial.net", "publicaccounting.com", "punkass.com",
            "puppy.com.my", "q.com", "qatar.io", "qlmail.com", "qq.com", "qrio.com",
            "qsl.net", "qudsmail.com", "queerplaces.com", "quepasa.com", "quick.cz", "quickwebmail.com",
            "r-o-o-t.com", "r320.hu", "raakim.com", "rbcmail.ru", "racingseat.com", "radicalz.com",
            "radiojobbank.com", "ragingbull.com", "raisingadaughter.com", "rallye-webmail.com", "rambler.ru", "ranmamail.com",
            "ravearena.com", "ravemail.co.za", "razormail.com", "real.ro", "realemail.net", "reallyfast.biz",
            "reallyfast.info", "rebels.com", "recife.net", "recme.net", "rediffmail.com", "rediffmailpro.com",
            "redseven.de", "redwhitearmy.com", "relia.com", "revenue.com", "rexian.com", "rhodeisland.usa.com",
            "ritmes.net", "rn.com", "roanokemail.com", "rochester-mail.com", "rock.com", "rocketmail.com",
            "rockfan.com", "rockinghamgateway.com", "rojname.com", "rol.ro", "rollin.com", "rome.com",
            "romymichele.com", "royal.net", "rpharmacist.com", "rt.nl", "ru.ru", "rushpost.com",
            "russiamail.com", "rxpost.net", "s-mail.com", "saabnet.com", "sacbeemail.com", "sacmail.com",
            "safe-mail.net", "safe-mailbox.com", "saigonnet.vn", "saint-mike.org", "samilan.net", "sandiego.com",
            "sanook.com", "sanriotown.com", "sapibon.com", "sapo.pt", "saturnfans.com", "sayhi.net",
            "sbcglobal.com", "scfn.net", "schweiz.org", "sci.fi", "sciaga.pl", "scrapbookscrapbook.com",
            "seapole.com", "search417.com", "seark.com", "sebil.com", "secretservices.net", "secure-jlnet.com",
            "seductive.com", "sendmail.ru", "sendme.cz", "sent.as", "sent.at", "sent.com",
            "serga.com.ar", "sermix.com", "server4free.de", "serverwench.com", "sesmail.com", "sexmagnet.com",
            "seznam.cz", "shadango.com", "she.com", "shuf.com", "siamlocalhost.com", "siamnow.net",
            "sify.com", "sinamail.com", "singapore.com", "singmail.com", "singnet.com.sg", "siraj.org",
            "sirindia.com", "sirunet.com", "sister.com", "sina.com", "sina.cn", "sinanail.com",
            "sistersbrothers.com", "sizzling.com", "slamdunkfan.com", "slickriffs.co.uk", "slingshot.com", "slo.net",
            "slomusic.net", "smartemail.co.uk", "smtp.ru", "snail-mail.net", "sndt.net", "sneakemail.com",
            "snoopymail.com", "snowboarding.com", "so-simple.org", "socamail.com", "softhome.net", "sohu.com",
            "sol.dk", "solidmail.com", "soon.com", "sos.lv", "soundvillage.org", "southcarolina.usa.com",
            "southdakota.usa.com", "sp.nl", "space.com", "spacetowns.com", "spamex.com", "spartapiet.com",
            "speed-racer.com", "speedpost.net", "speedymail.org", "spils.com", "spinfinder.com", "sportemail.com",
            "spray.net", "spray.no", "spray.se", "spymac.com", "srbbs.com", "srilankan.net",
            "ssan.com", "ssl-mail.com", "stade.fr", "stalag13.com", "stampmail.com", "starbuzz.com",
            "starline.ee", "starmail.com", "starmail.org", "starmedia.com", "starspath.com", "start.com.au",
            "start.no", "stribmail.com", "student.com", "student.ednet.ns.ca", "studmail.com", "sudanmail.net",
            "suisse.org", "sunbella.net", "sunmail1.com", "sunpoint.net", "sunrise.ch", "sunumail.sn",
            "sunuweb.net", "suomi24.fi", "superdada.it", "supereva.com", "supereva.it", "supermailbox.com",
            "superposta.com", "surf3.net", "surfassistant.com", "surfsupnet.net", "surfy.net", "surimail.com",
            "surnet.cl", "sverige.nu", "svizzera.org", "sweb.cz", "swift-mail.com", "swissinfo.org",
            "swissmail.net", "switzerland.org", "syom.com", "syriamail.com", "t-mail.com", "t-net.net.ve",
            "t2mail.com", "tabasheer.com", "talk21.com", "talkcity.com", "tangmonkey.com", "tatanova.com",
            "taxcutadvice.com", "techemail.com", "technisamail.co.za", "teenmail.co.uk", "teenmail.co.za", "tejary.com",
            "telebot.com", "telefonica.net", "telegraf.by", "teleline.es", "telinco.net", "telkom.net",
            "telpage.net", "telstra.com", "telenet.be", "telusplanet.net", "tempting.com", "tenchiclub.com",
            "tennessee.usa.com", "terrapins.com", "texas.usa.com", "texascrossroads.com", "tfz.net", "thai.com",
            "thaimail.com", "thaimail.net", "the-fastest.net", "the-quickest.com", "thegame.com", "theinternetemail.com",
            "theoffice.net", "thepostmaster.net", "theracetrack.com", "theserverbiz.com", "thewatercooler.com", "thewebpros.co.uk",
            "thinkpost.net", "thirdage.com", "thundermail.com", "tim.it", "timemail.com", "tin.it",
            "tinati.net", "tiscalinet.it", "tjohoo.se", "tkcity.com", "tlcfan.com", "tlen.pl",
            "tmicha.net", "todito.com", "todoperros.com", "tokyo.com", "topchat.com", "topmail.com.ar",
            "topmail.dk", "topmail.co.ie", "topmail.co.in", "topmail.co.nz", "topmail.co.uk", "topmail.co.za",
            "topsurf.com", "toquedequeda.com", "torba.com", "torchmail.com", "totalmail.com", "totalsurf.com",
            "totonline.net", "tough.com", "toughguy.net", "trav.se", "trevas.net", "tripod-mail.com",
            "triton.net", "trmailbox.com", "tsamail.co.za", "turbonett.com", "turkey.com", "tvnet.lv",
            "twc.com", "typemail.com", "u2club.com", "uae.ac", "ubbi.com", "ubbi.com.br",
            "uboot.com", "ugeek.com", "uk2.net", "uk2net.com", "ukr.net", "ukrpost.net",
            "ukrpost.ua", "uku.co.uk", "ulimit.com", "ummah.org", "unbounded.com", "unican.es",
            "unicum.de", "unimail.mn", "unitedemailsystems.com", "universal.pt", "universia.cl", "universia.edu.ve",
            "universia.es", "universia.net.co", "universia.net.mx", "universia.pr", "universia.pt", "universiabrasil.net",
            "unofree.it", "uol.com.ar", "uol.com.br", "uole.com", "uolmail.com", "uomail.com",
            "uraniomail.com", "urbi.com.br", "ureach.com", "usanetmail.com", "userbeam.com", "utah.usa.com",
            "uyuyuy.com", "v-sexi.com", "v3mail.com", "vegetarisme.be", "velnet.com", "velocall.com",
            "vercorreo.com", "verizonmail.com", "vermont.usa.com", "verticalheaven.com", "veryfast.biz", "veryspeedy.net",
            "vfemail.net", "vietmedia.com", "vip.gr", "virgilio.it", "virgin.net", "virginia.usa.com",
            "virtual-mail.com", "visitmail.com", "visto.com", "vivelared.com", "vjtimail.com", "vnn.vn",
            "vsnl.com", "vsnl.net", "vodamail.co.za", "voila.fr", "volkermord.com", "vosforums.com",
            "w.cn", "walla.com", "walla.co.il", "wallet.com", "wam.co.za", "wanadoo.co.uk",
            "wanadoo.es", "wanadoo.fr", "wanex.ge", "wap.hu", "wapda.com", "wapicode.com",
            "wappi.com", "warpmail.net", "washington.usa.com", "wassup.com", "waterloo.com", "waumail.com",
            "wazmail.com", "wearab.net", "web-mail.com.ar", "web.de", "web.nl", "web2mail.com",
            "webaddressbook.com", "webbworks.com", "webcity.ca", "webdream.com", "webemaillist.com", "webindia123.com",
            "webinfo.fi", "webjump.com", "webl-3.br.inter.net", "webmail.co.yu", "webmail.co.za", "webmails.com",
            "webmailv.com", "webpim.cc", "webspawner.com", "webstation.com", "websurfer.co.za", "webtopmail.com",
            "webtribe.net", "webtv.net", "weedmail.com", "weekonline.com", "weirdness.com", "westvirginia.usa.com",
            "whale-mail.com", "whipmail.com", "who.net", "whoever.com", "wildcats.com", "wildmail.com",
            "williams.net.ar", "winning.com", "winningteam.com", "winwinhosting.com", "wisconsin.usa.com", "witelcom.com",
            "witty.com", "wolverines.com", "wooow.it", "workmail.co.za", "worldcrossing.com", "worldemail.com",
            "worldmedic.com", "worldonline.de", "wowmail.com", "wp.pl", "wprost.pl", "wrongmail.com",
            "wtonetwork.com", "wurtele.net", "www.com", "www.consulcredit.it", "wyoming.usa.com", "x-mail.net",
            "xasa.com", "xfreehosting.com", "xmail.net", "xmsg.com", "xnmsn.cn", "xoom.com",
            "xtra.co.nz", "xuite.net", "xpectmore.com", "xrea.com", "xsmail.com", "xzapmail.com",
            "y7mail.com", "yahala.co.il", "yaho.com", "yalla.com.lb", "ya.com", "yeah.net",
            "ya.ru", "yahoomail.com", "yam.com", "yamal.info", "yapost.com", "yawmail.com",
            "yebox.com", "yehey.com", "yellow-jackets.com", "yellowstone.net", "yenimail.com", "yepmail.net",
            "yifan.net", "ymail.com", "your-mail.com", "yours.com", "yourwap.com", "yyhmail.com",
            "z11.com", "z6.com", "zednet.co.uk", "zeeman.nl", "ziplip.com", "zipmail.com.br",
            "zipmax.com", "zmail.pt", "zmail.ru", "zona-andina.net", "zonai.com", "zoneview.net",
            "zonnet.nl", "zoho.com", "zoomshare.com", "zoznam.sk", "zubee.com", "zuvio.com",
            "zwallet.com", "zworg.com", "zybermail.com", "zzn.com", "126.com", "139.com",
            "163.com", "188.com", "189.cn", "263.net", "9.cn", "vip.126.com",
            "vip.163.com", "vip.188.com", "vip.sina.com", "vip.sohu.com", "vip.sohu.net", "vip.tom.com",
            "vip.qq.com", "vipsohu.net", "clovermail.net", "mail-on.us", "chewiemail.com", "offcolormail.com",
            "powdermail.com", "tightmail.com", "toothandmail.com", "tushmail.com", "openmail.cc", "expressmail.dk",
            "4xn.de", "5x2.de", "5x2.me", "aufdrogen.de", "auf-steroide.de", "besser-als-du.de",
            "brainsurfer.de", "chillaxer.de", "cyberkriminell.de", "danneben.so", "freemailen.de", "freemailn.de",
            "ist-der-mann.de", "ist-der-wahnsinn.de", "ist-echt.so", "istecht.so", "ist-genialer.de", "ist-schlauer.de",
            "ist-supersexy.de", "kann.so", "mag-spam.net", "mega-schlau.de", "muss.so", "nerd4life.de",
            "ohne-drogen-gehts.net", "on-steroids.de", "scheint.so", "staatsterrorist.de", "super-gerissen.de", "unendlich-schlau.de",
            "vip-client.de", "will-keinen-spam.de", "zu-geil.de", "rbox.me", "rbox.co", "tunome.com",
            "acatperson.com", "adogperson.com", "all4theskins.com", "allsportsrock.com", "alwaysgrilling.com", "alwaysinthekitchen.com",
            "alwayswatchingmovies.com", "alwayswatchingtv.com", "asylum.com", "basketball-email.com", "beabookworm.com", "beagolfer.com",
            "beahealthnut.com", "believeinliberty.com", "bestcoolcars.com", "bestjobcandidate.com", "besure2vote.com", "bigtimecatperson.com",
            "bigtimedogperson.com", "bigtimereader.com", "bigtimesportsfan.com", "blackvoices.com", "capsfanatic.com", "capshockeyfan.com",
            "capsred.com", "car-nut.net", "cat-person.com", "catpeoplerule.com", "chat-with-me.com", "cheatasrule.com",
            "crazy4baseball.com", "crazy4homeimprovement.com", "crazy4mail.com", "crazyaboutfilms.net", "crazycarfan.com", "crazyforemail.com",
            "crazymoviefan.com", "descriptivemail.com", "differentmail.com", "dog-person.com", "dogpeoplerule.com", "easydoesit.com",
            "expertrenovator.com", "expressivemail.com", "fanaticos.com", "fanofbooks.com", "fanofcomputers.com", "fanofcooking.com",
            "fanoftheweb.com", "fieldmail.com", "fleetmail.com", "focusedonprofits.com", "focusedonreturns.com", "futboladdict.com",
            "games.com", "getintobooks.com", "hail2theskins.com", "hitthepuck.com", "i-dig-movies.com", "i-love-restaurants.com",
            "idigcomputers.com", "idigelectronics.com", "idigvideos.com", "ilike2helpothers.com", "ilike2invest.com", "ilike2workout.com",
            "ilikeelectronics.com", "ilikeworkingout.com", "ilovehomeprojects.com", "iloveourteam.com", "iloveworkingout.com", "in2autos.net",
            "interestedinthejob.com", "intomotors.com", "iwatchrealitytv.com", "lemondrop.com", "love2exercise.com", "love2workout.com",
            "lovefantasysports.com", "lovetoexercise.com", "luvfishing.com", "luvgolfing.com", "luvsoccer.com", "mail4me.com",
            "majorgolfer.com", "majorshopaholic.com", "majortechie.com", "mcom.com", "motor-nut.com", "moviefan.com",
            "mycapitalsmail.com", "mycatiscool.com", "myfantasyteamrules.com", "myteamisbest.com", "netbusiness.com", "news-fanatic.com",
            "newspaperfan.com", "onlinevideosrock.com", "realbookfan.com", "realhealthnut.com", "realitytvaddict.net", "realitytvnut.com",
            "reallyintomusic.com", "realtravelfan.com", "redskinscheer.com", "redskinsfamily.com", "redskinsfancentral.com", "redskinshog.com",
            "redskinsrule.com", "redskinsspecialteams.com", "redskinsultimatefan.com", "scoutmail.com", "skins4life.com", "stargate2.com",
            "stargateatlantis.com", "stargatefanclub.com", "stargatesg1.com", "stargateu.com", "switched.com", "thegamefanatic.com",
            "total-techie.com", "totalfoodnut.com", "totally-into-cooking.com", "totallyintobaseball.com", "totallyintobasketball.com", "totallyintocooking.com",
            "totallyintofootball.com", "totallyintogolf.com", "totallyintohockey.com", "totallyintomusic.com", "totallyintoreading.com", "totallyintosports.com",
            "totallyintotravel.com", "totalmoviefan.com", "travel2newplaces.com", "tvchannelsurfer.com", "ultimateredskinsfan.com", "videogamesrock.com",
            "volunteeringisawesome.com", "wayintocomputers.com", "whatmail.com", "when.com", "wild4music.com", "wildaboutelectronics.com",
            "workingaroundthehouse.com", "workingonthehouse.com", "writesoon.com", "xmasmail.com", "arab.ir", "denmark.ir",
            "egypt.ir", "icq.ir", "ir.ae", "iraq.ir", "ire.ir", "ireland.ir",
            "irr.ir", "jpg.ir", "ksa.ir", "kuwait.ir", "london.ir", "paltalk.ir",
            "spain.ir", "sweden.ir", "tokyo.ir", "111mail.com", "123iran.com", "37.com",
            "420email.com", "4degreez.com", "4-music-today.com", "actingbiz.com", "allhiphop.com", "anatomicrock.com",
            "animeone.com", "asiancutes.com", "a-teens.net", "ausi.com", "autoindia.com", "autopm.com",
            "barriolife.com", "b-boy.com", "beautifulboy.com", "bgay.com", "bicycledata.com", "bicycling.com",
            "bigheavyworld.com", "bigmailbox.net", "bikerheaven.net", "bikermail.com", "billssite.com", "blackandchristian.com",
            "blackcity.net", "blackvault.com", "bmxtrix.com", "boarderzone.com", "boatnerd.com", "bolbox.com",
            "bongmail.com", "bowl.com", "butch-femme.org", "byke.com", "calle22.com", "cannabismail.com",
            "catlovers.com", "certifiedbitches.com", "championboxing.com", "chatway.com", "chillymail.com", "classprod.com",
            "classycouples.com", "congiu.net", "coolshit.com", "corpusmail.com", "cyberunlimited.org", "cycledata.com",
            "darkfear.com", "darkforces.com", "dirtythird.com", "dopefiends.com", "draac.com", "drakmail.net",
            "dr-dre.com", "dreamstop.com", "egypt.net", "emailfast.com", "envirocitizen.com", "escapeartist.com",
            "ezsweeps.com", "famous.as", "farts.com", "feelingnaughty.com", "firemyst.com", "freeonline.com",
            "fudge.com", "funkytimes.com", "gamerssolution.com", "gazabo.net", "glittergrrrls.com", "goatrance.com",
            "goddess.com", "gohip.com", "gospelcity.com", "gothicgirl.com", "grapemail.net", "greatautos.org",
            "guy.com", "haitisurf.com", "happyhippo.com", "hateinthebox.com", "houseofhorrors.com", "hugkiss.com",
            "hullnumber.com", "idunno4recipes.com", "ihatenetscape.com", "intimatefire.com", "irow.com", "jazzemail.com",
            "juanitabynum.com", "kanoodle.com", "kickboxing.com", "kidrock.com", "kinkyemail.com", "kool-things.com",
            "latinabarbie.com", "latinogreeks.com", "leesville.com", "loveemail.com", "lowrider.com", "lucky7lotto.net",
            "madeniggaz.net", "mailbomb.com", "marillion.net", "megarave.com", "mofa.com", "motley.com",
            "music.com", "musician.net", "musicsites.com", "netbroadcaster.com", "netfingers.com", "net-surf.com",
            "nocharge.com", "operationivy.com", "paidoffers.net", "pcbee.com", "persian.com", "petrofind.com",
            "phunkybitches.com", "pikaguam.com", "pinkcity.net", "pitbullmail.com", "planetsmeg.com", "poop.com",
            "poormail.com", "potsmokersnet.com", "primetap.com", "project420.com", "prolife.net", "puertoricowow.com",
            "puppetweb.com", "rapstar.com", "rapworld.com", "rastamall.com", "ratedx.net", "ravermail.com",
            "relapsecult.com", "remixer.com", "rockeros.com", "romance106fm.com", "singalongcenter.com", "sketchyfriends.com",
            "slayerized.com", "smartstocks.com", "soulja-beatz.org", "specialoperations.com", "speedymail.net", "spells.com",
            "streetracing.com", "subspacemail.com", "sugarray.com", "superbikeclub.com", "superintendents.net", "surfguiden.com",
            "sweetwishes.com", "tattoodesign.com", "teamster.net", "teenchatnow.com", "the5thquarter.com", "theblackmarket.com",
            "tombstone.ws", "troamail.org", "u2tours.com", "vitalogy.org", "whatisthis.com", "wrestlezone.com",
            "abha.cc", "agadir.cc", "ahsa.ws", "ajman.cc", "ajman.us", "ajman.ws",
            "albaha.cc", "algerie.cc", "alriyadh.cc", "amman.cc", "aqaba.cc", "arar.ws",
            "aswan.cc", "baalbeck.cc", "bahraini.cc", "banha.cc", "bizerte.cc", "blida.info",
            "buraydah.cc", "cameroon.cc", "dhahran.cc", "dhofar.cc", "djibouti.cc", "dominican.cc",
            "eritrea.cc", "falasteen.cc", "fujairah.cc", "fujairah.us", "fujairah.ws", "gabes.cc",
            "gafsa.cc", "giza.cc", "guinea.cc", "hamra.cc", "hasakah.com", "hebron.tv",
            "homs.cc", "ibra.cc", "irbid.ws", "ismailia.cc", "jadida.cc", "jadida.org",
            "jerash.cc", "jizan.cc", "jouf.cc", "kairouan.cc", "karak.cc", "khaimah.cc",
            "khartoum.cc", "khobar.cc", "kuwaiti.tv", "kyrgyzstan.cc", "latakia.cc", "lebanese.cc",
            "lubnan.cc", "lubnan.ws", "madinah.cc", "maghreb.cc", "manama.cc", "mansoura.tv",
            "marrakesh.cc", "mascara.ws", "meknes.cc", "muscat.tv", "muscat.ws", "nabeul.cc",
            "nabeul.info", "nablus.cc", "nador.cc", "najaf.cc", "omani.ws", "omdurman.cc",
            "oran.cc", "oued.info", "oued.org", "oujda.biz", "oujda.cc", "pakistani.ws",
            "palmyra.cc", "palmyra.ws", "portsaid.cc", "qassem.cc", "quds.cc", "rabat.cc",
            "rafah.cc", "ramallah.cc", "safat.biz", "safat.info", "safat.us", "safat.ws",
            "salalah.cc", "salmiya.biz", "sanaa.cc", "seeb.cc", "sfax.ws", "sharm.cc",
            "sinai.cc", "siria.cc", "sousse.cc", "sudanese.cc", "suez.cc", "tabouk.cc",
            "tajikistan.cc", "tangiers.cc", "tanta.cc", "tayef.cc", "tetouan.cc", "timor.cc",
            "tunisian.cc", "urdun.cc", "yanbo.cc", "yemeni.cc", "yunus.cc", "zagazig.cc",
            "zambia.cc", "5005.lv", "a.org.ua", "bmx.lv", "company.org.ua", "coolmail.ru",
            "dino.lv", "eclub.lv", "e-mail.am", "fit.lv", "hacker.am", "human.lv",
            "iphon.biz", "latchess.com", "loveis.lv", "lv-inter.net", "pookmail.com", "sexriga.lv",
            "accountant.com", "acdcfan.com", "activist.com", "adexec.com", "africamail.com", "aircraftmail.com",
            "allergist.com", "alumni.com", "alumnidirector.com", "angelic.com", "appraiser.net", "archaeologist.com",
            "arcticmail.com", "artlover.com", "asia-mail.com", "asia.com", "atheist.com", "auctioneer.net",
            "australiamail.com", "bartender.net", "bellair.net", "berlin.com", "bikerider.com", "birdlover.com",
            "blader.com", "boardermail.com", "brazilmail.com", "brew-master.com", "brew-meister.com", "bsdmail.com",
            "californiamail.com", "cash4u.com", "catlover.com", "cheerful.com", "chef.net", "chemist.com",
            "chinamail.com", "clerk.com", "clubmember.org", "collector.org", "columnist.com", "comic.com",
            "computer4u.com", "consultant.com", "contractor.net", "coolsite.net", "counsellor.com", "cutey.com",
            "cyber-wizard.com", "cyberdude.com", "cybergal.com", "cyberservices.com", "dallasmail.com", "dbzmail.com",
            "deliveryman.com", "diplomats.com", "disciples.com", "discofan.com", "disposable.com", "doctor.com",
            "doglover.com", "doramail.com", "dr.com", "dublin.com", "dutchmail.com", "elvisfan.com",
            "email.com", "engineer.com", "englandmail.com", "europe.com", "europemail.com", "execs.com",
            "fastservice.com", "financier.com", "fireman.net", "galaxyhit.com", "gardener.com", "geologist.com",
            "germanymail.com", "graduate.org", "graphic-designer.com", "greenmail.net", "groupmail.com", "hackermail.com",
            "hairdresser.net", "hilarious.com", "hiphopfan.com", "homemail.com", "hot-shot.com", "housemail.com",
            "humanoid.net", "iname.acom", "iname.com", "innocent.com", "inorbit.com", "instruction.com",
            "instructor.net", "insurer.com", "irelandmail.com", "israelmail.com", "italymail.com", "job4u.com",
            "journalist.com", "keromail.com", "kissfans.com", "kittymail.com", "koreamail.com", "legislator.com",
            "linuxmail.org", "lobbyist.com", "lovecat.com", "madonnafan.com", "mail-me.com", "mail.com",
            "marchmail.com", "metalfan.com", "mexicomail.com", "minister.com", "moscowmail.com", "munich.com",
            "musician.org", "muslim.com", "myself.com", "net-shopping.com", "ninfan.com", "nonpartisan.com",
            "null.net", "nycmail.com", "oath.com", "optician.com", "orthodontist.net", "pacific-ocean.com",
            "pacificwest.com", "pediatrician.com", "petlover.com", "photographer.net", "physicist.net", "planetmail.com",
            "planetmail.net", "polandmail.com", "politician.com", "post.com", "presidency.com", "priest.com",
            "programmer.net", "protestant.com", "publicist.com", "qualityservice.com", "radiologist.net", "ravemail.com",
            "realtyagent.com", "reborn.com", "reggaefan.com", "registerednurses.com", "reincarnate.com", "religious.com",
            "repairman.com", "representative.com", "rescueteam.com", "rocketship.com", "safrica.com", "saintly.com",
            "salesperson.net", "samerica.com", "sanfranmail.com", "scientist.com", "scotlandmail.com", "secretary.net",
            "snakebite.com", "socialworker.net", "sociologist.com", "solution4u.com", "songwriter.net", "spainmail.com",
            "surgical.net", "swedenmail.com", "swissmail.com", "teachers.org", "tech-center.com", "techie.com",
            "technologist.com", "theplate.com", "therapist.net", "toke.com", "toothfairy.com", "torontomail.com",
            "tvstar.com", "umpire.com", "usa.com", "uymail.com", "webname.com", "worker.com",
            "workmail.com", "writeme.com", "cloud.me", "indamail.hu", "irj.hu", "qip.ru",
            "zooglemail.com", "a.ua", "fm.com.ua", "ua.fm", "inet.ua", "meta.ua",
            "bk.ru", "list.ru", "borda.ru", "fromru.com", "front.ru", "krovatka.su",
            "nm.ru", "5ballov.ru", "aeterna.ru", "ziza.ru", "memori.ru", "photofile.ru",
            "fotoplenka.ru", "pochta.com", "webmail.ru", "email.ru", "fax.ru", "aport.ru",
            "omen.ru", "atrus.ru", "aport2000.ru", "nm.ru", "tut.by",
            // free email providers end
        );
    }
}
